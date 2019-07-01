<?php if (!defined('ABSPATH')) die;

// handles redirects from old Blogger link structure to new WordPress equivalents
// WIP
function pipdig_blogger_redirects() {

	if (is_admin()) {
		return;
	}

	if (!is_404()) {
		return;
	}

	$new_url = home_url('/');

	$permalink_structure = get_option('permalink_structure');

	// check if pretty permalinks are active. If not, bail.
	if (!$permalink_structure) {
		return;
	}

	global $wp;
	$split = explode('/', $wp->request);

	if ($split[0] == 'feeds' && $split[1] == 'posts') { // feeds

		$new_url = site_url().'/feed';

	} elseif ($split[0] == 'search' && $split[1] == 'label' && !empty($split[2])) { // labels

		$label = str_replace('%20', '-', $split[2]);

		// check if it's a category
		if (term_exists($label, 'category')) {
			$base = get_option('category_base');
			if (empty($base)) {
				$base = 'category';
			}
		} else {
			// if not, let's send to tags
			$base = get_option('tag_base');
			if (empty($base)) {
				$base = 'tag';
			}
		}

		$new_url = site_url().'/'.$base.'/'.strtolower($label);

	} elseif (count($split) == 2 && $split[0] === 'p' && strpos($split[1], '.html') !== false) { // pages
		// /p/about.html to /about

		$page_slug = str_replace('.html', '', $split[1]);
		$new_url = site_url().'/'.$page_slug;

	} elseif (is_numeric($split[0]) && !empty($split[2]) && strpos($split[2], '.html') !== false) { // posts
		// /2018/01/02/post-title.html to ...

		if ($permalink_structure != '/%year%/%monthnum%/%postname%.html') {

			$prefix = $end_slash = '';
			$year = $split[0];
			$month = $split[1];
			$post_slug = str_replace('.html', '', $split[2]);

			if ($permalink_structure == '/%year%/%monthnum%/%postname%/') {
				$prefix = '/'.$year.'/'.$month;
			}

			// Add a slash on the end if the permalink structure is set that way
			if (substr($permalink_structure, -1) == '/') {
				$end_slash = '/';
			}

			$new_url = site_url().$prefix.'/'.$post_slug.$end_slash;

		} else {
			// the permalinks are changed to /%year%/%monthnum%/%postname%.html, so we don't need to redirect anything
			return;
		}

	}

	wp_redirect( $new_url, 301 );
	die;

}
add_action( 'template_redirect', 'pipdig_blogger_redirects' );
