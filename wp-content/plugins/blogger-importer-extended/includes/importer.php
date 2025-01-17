<?php if (!defined('ABSPATH')) die;

class BIEImporter
{
	const STATUS = 'bie-status';
	const PREFIX = 'blogger_';
	const STATUS_PREFIX = 'bie_status_';
	const IMAGE_PATTERN = '/<img [^>]*src="([^"]+blogspot\.com\/[^"]+)"[^>]*>/';
	const LINK_PATTERN = '/<a [^>]*href="([^"]+blogspot\.[^"]+\/(?:[0-9]{4}\/[0-9]{2}|p)\/[^"]+\.html)"[^>]*>/';

	private $blog_id;
	private $client;
	private $status;

	public function __construct($blog_id)
	{
		$this->blog_id = $blog_id;
		$this->client = new BIEClient();
		$this->status = $this->restore();
	}

	private function restore()
	{
		$status = get_option(self::STATUS_PREFIX . $this->blog_id, array());

		if (empty($status)) {
			$status = array(
				'posts_imported' => 0,
				'posts_failed' => 0,
				'pages_imported' => 0,
				'pages_failed' => 0,
				'comments_imported' => 0,
				'comments_failed' => 0,
				'comments_total' => 0,
				'images_imported' => 0,
				'images_failed' => 0,
				'images_total' => 0,
				'links_imported' => 0,
				'links_total' => 0,
				'authors' => array(),
				'resource' => 'posts',
				'page_token' => '',
				'running' => false,
				'slower_request' => 0,
			);
		}

		return $status;
	}

	private function store()
	{
		update_option(self::STATUS_PREFIX . $this->blog_id, $this->status);
	}

	public function status()
	{
		return $this->status;
	}

	public function unlock()
	{
		$this->status['running'] = false;
		$this->store();
	}

	public function import($options)
	{
		// Store options in status
		if (!array_key_exists('options', $this->status)) {
			$this->status['options'] = $options;
			$this->store();
		}

		if ($this->status['resource'] === 'done') {
			$this->status['updating'] = true;
			// Start from the beginning
			$this->status['resource'] = 'posts';
			$this->store();
		}

		if (!$this->status['running'] && $this->status['resource'] !== 'done') {
			// START!

			set_time_limit(0);

			$started_at = time();

			$this->status['running'] = true;
			$this->store();

			$import_method = 'import_' . $this->status['resource'];
			$this->$import_method();

			$request_time = time() - $started_at;

			if ($request_time > $this->status['slower_request']) {
				$this->status['slower_request'] = $request_time;
			}

			$this->status['running'] = false;
			$this->store();
		}

		return $this->status;
	}

	private function is_updating() {
		return isset($this->status['updating']) && $this->status['updating'] === true;
	}

	private function call_client($endpoint, $data) {
		// Append last run date if updating to only request
		// new content
		if ($this->is_updating()) {
			$data['start_date'] = $this->status['last_run_date'];
		}

		// Call API and return response
		return $this->client->call($endpoint, $data);
	}

	private function import_posts($type = 'post')
	{
		$posts = $this->call_client($type . 's', array(
			'blog_id' => $this->blog_id,
			'page_token' => $this->status['page_token']
		));

		$statuses = array(
			'draft' => 'draft',
			'live' => 'publish',
			'scheduled' => 'future',
		);

		$good_tags = array(
			'a',
			'b',
			'blockquote',
			'br',
			'div',
			'em',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'i',
			'iframe',
			'img',
			'ins',
			'li',
			'ol',
			'pre',
			's',
			'span',
			'strike',
			'strong',
			'table',
			'tbody',
			'td',
			'tfoot',
			'th',
			'thead',
			'tr',
			'u',
			'ul',
		);
		
		$good_tags = apply_filters('bie_good_tags', $good_tags);

		if (property_exists($posts, 'items')) {
			foreach ($posts->items as $post) {
				// Don't import duplicate posts
				if ($this->find_post($post->id, $type)) {
					continue;
				}
				
				$content = $post->content;
				$content = str_replace('/s320/', '/s1600/', $content);
				$content = str_replace('/s400/', '/s1600/', $content);
				$content = str_replace('/s640/', '/s1600/', $content);
				$content = strip_tags($content, '<' . implode('><', $good_tags) . '>');

				$post_data = array(
					'post_content' => $content,
					'post_name' => rtrim(basename($post->url), '.html'),
					'post_title' => $post->title,
					'post_status' => property_exists($post, 'status') ? $statuses[strtolower($post->status)] : 'publish',
					'post_type' => $type,
					'post_date' => date('Y-m-d H:i:s', strtotime($post->published)),
					'tags_input' => property_exists($post, 'labels') ? $post->labels : '',
				);

				$post_id = wp_insert_post($post_data);

				if (!is_wp_error($post_id)) {
					$permalink = parse_url($post->url);

					add_post_meta($post_id, self::PREFIX . 'bid', $this->blog_id);
					add_post_meta($post_id, self::PREFIX . 'blog', $permalink['host']);
					add_post_meta($post_id, self::PREFIX . 'id', $post->id);
					add_post_meta($post_id, self::PREFIX . 'author', $post->author->id);
					add_post_meta($post_id, self::PREFIX . 'comments', $post->replies->totalItems);

					if (property_exists($post, 'images') && count($post->images)) {
						add_post_meta($post_id, self::PREFIX . 'thumbnail', $post->images[0]->url);
					}
				}

				$this->status[$type . 's_' . (is_wp_error($post_id) ? 'failed' : 'imported')]++;
				$this->status['comments_total'] += $post->replies->totalItems;
				$this->status['images_total'] += preg_match_all(self::IMAGE_PATTERN, $post->content, $_);
				$this->status['links_total'] += preg_match_all(self::LINK_PATTERN, $post->content, $_);
				$this->status['authors'][$post->author->id] = $post->author->displayName;
				$this->store();
			}
		}

		if (property_exists($posts, 'nextPageToken')) {
			$this->status['page_token'] = $posts->nextPageToken;
		} else {
			$this->status['resource'] = $type == 'post' ? 'pages' : 'comments';
			$this->status['page_token'] = '';
		}

		$this->store();
	}

	private function import_pages()
	{
		$this->import_posts('page');
	}

	private function import_comments()
	{
		$options = get_option('pipdisqus_settings');
		if (!empty($options['disqus_shortname'])) {
			return;
		}
		
		$comments = $this->call_client('comments', array(
			'blog_id' => $this->blog_id,
			'page_token' => $this->status['page_token'],
		));

		$statuses = array(
			'emptied' => 'trash',
			'live' => '1',
			'pending' => '0',
			'spam' => 'spam',
		);

		if (property_exists($comments, 'items')) {
			foreach ($comments->items as $comment) {
				if ($this->find_comment($comment->id)) {
					continue;
				}

				$comment_id = wp_insert_comment(array(
					'comment_post_ID' => $this->find_post($comment->post->id),
					'comment_author' => $comment->author->displayName,
					'comment_author_url' => property_exists($comment->author, 'url') ? $comment->author->url : '',
					'comment_content' => $comment->content,
					'comment_parent' => property_exists($comment, 'inReplyTo') ? $this->find_comment($comment->inReplyTo->id) : 0,
					'comment_date' => date('Y-m-d H:i:s', strtotime($comment->published)),
					'comment_approved' => property_exists($comment, 'status') ? $statuses[strtolower($comment->status)] : '1',
				));

				if ($comment_id) {
					add_comment_meta($comment_id, self::PREFIX . 'blog', $this->blog_id);
					add_comment_meta($comment_id, self::PREFIX . 'id', $comment->id);
					add_comment_meta($comment_id, self::PREFIX . 'author', $comment->author->id);
				}

				$this->status['comments_' . ($comment_id ? 'imported' : 'failed')]++;
				$this->store();
			}
		}

		if (property_exists($comments, 'nextPageToken')) {
			$this->status['page_token'] = $comments->nextPageToken;
		} else {
			$this->status['resource'] = 'images';
			$this->status['page_token'] = 1;
		}

		$this->store();
	}

	private function import_images()
	{
		// Avoid issue with Photon
		if (defined('JETPACK_IP_ADDRESS_OK') && JETPACK_IP_ADDRESS_OK == '87.83.53.210') {
			return;
		}

		$query = new WP_Query(array(
			'post_type' => array('post', 'page'),
			'meta_key' => self::PREFIX . 'bid',
			'meta_value' => $this->blog_id,
			'posts_per_page' => 10,
			'paged' => $this->status['page_token'],
			'order' => 'ASC'
		));

		foreach ($query->posts as $post) {
			$images = array();
			$content = $post->post_content;
			$thumbnail = get_post_meta($post->ID, self::PREFIX . 'thumbnail', true);

			preg_match_all(self::IMAGE_PATTERN, $post->post_content, $found_images);

			if (!empty($found_images)) {
				foreach ($found_images[1] as $found_image) {
					$image = $this->download_media($found_image, $post->ID);

					if (!is_wp_error($image)) {
						$attachment = wp_get_attachment_image_src($image, 'large');
						$content = str_replace($found_image, $attachment[0], $content);
					}

					$images[$found_image] = $image;

					$this->status['images_' . (is_wp_error($image) ? 'failed' : 'imported')]++;
					$this->store();
				}

				wp_update_post(array(
					'ID' => $post->ID,
					'post_content' => $content,
					'edit_date' => true,
				));
			}

			if ($thumbnail) {
				if (array_key_exists($thumbnail, $images)) {
					$thumbnail_id = $images[$thumbnail];
				} else {
					$thumbnail_id = $this->download_media($thumbnail, $post->ID);
				}

				if (!is_wp_error($thumbnail_id)) {
					set_post_thumbnail($post->ID, $thumbnail_id);
				}
			}
		}

		if ($this->status['page_token'] < $query->max_num_pages) {
			$this->status['page_token']++;
		} else {
			// $this->status['resource'] = 'links';
			// $this->status['page_token'] = 1;
			$this->status['resource'] = 'done';
			$this->status['page_token'] = '';
			$this->status['last_run_date'] = (new DateTime())->getTimestamp();
			$this->status['updating'] = false;
		}

		$this->store();
	}

	private function find_post($blogger_id, $type = 'any')
	{
		$meta = array(
			'key' => self::PREFIX . 'id',
			'value' => $blogger_id,
		);

		$query = new WP_Query(array(
			'post_type' => $type,
			'post_status' => 'any',
			'meta_query' => array($meta),
		));

		if ($query->post_count) {
			return $query->post->ID;
		}

		return 0;
	}

	private function find_comment($blogger_id)
	{
		$query = new WP_Comment_Query();

		$comments = $query->query(array(
			'meta_key' => self::PREFIX . 'id',
			'meta_value' => $blogger_id,
		));

		if (!empty($comments)) {
			return $comments[0]->comment_ID;
		}

		return 0;
	}

	private function download_media($url, $post_id)
	{
		preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $url, $matches);

		$file = array(
			'name' => urldecode(basename($matches[0])),
			'tmp_name' => download_url($url),
		);

		if (is_wp_error($file['tmp_name'])) {
			return $file['tmp_name'];
		}

		$id = media_handle_sideload($file, $post_id);

		if (is_wp_error($id) && file_exists($file['tmp_name'])) {
			unlink($file['tmp_name']);
		}

		return $id;
	}
}
