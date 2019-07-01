<?php if (!defined('ABSPATH')) die;

require 'exception-helper.php';

class BIECore extends BIETemplate
{
    const SLUG = 'pipdig-wordpress-migrator';
    const NAME = 'pipdig Wordpress Migrator';
    const ID = 'bie_id';

    private $client;
    private $bootstrap;

    public function __construct($bootstrap)
    {
        $this->client = new BIEClient();
        $this->bootstrap = $bootstrap;
    }

    static public function install()
    {
        if (!self::blog()) {
            add_option(self::ID, md5(uniqid(rand(), true)));
        }
    }
	
    public static function blog()
    {
        return get_option(self::ID);
    }

    public function load()
    {
        add_action('admin_init', array($this, 'register'));
        add_action('wp_ajax_bie_import', array($this, 'import'));
        add_action('wp_ajax_bie_status', array($this, 'status'));
        add_action('wp_ajax_bie_authors', array($this, 'authors'));
        add_action('wp_ajax_bie_unlock', array($this, 'unlock'));
        add_action('wp_ajax_bie_reset', array($this, 'reset'));

        add_filter('plugin_action_links_' . plugin_basename($this->bootstrap), array($this, 'links'));
    }

    public function register()
    {
        register_importer(self::SLUG, self::NAME, __('Import posts, pages, comments, images, labels and authors from a Blogger blog.', self::SLUG), array($this, 'run'));
    }

    public function links($links)
    {
        $links[] = '<a href="' . admin_url('admin.php?import=' . self::SLUG) . '">' . __('Run Importer') . '</a>';

        return $links;
    }

    /**
     * Handles API errors gracefully by showing the 
     * exception template
     */
    private function handled_call($operation, $params = array())
    {
        try
        {
            return $this->client->call($operation, $params);
        }
        catch (ClientErrorException $ex)
        {
            $this->gracefully_handle_exception($ex);
        }
    }

    private function gracefully_handle_exception($ex)
    {
        $this->render('exception', array(
            'message' => BIEExceptionHelper::pretify($ex),
        ));
    }

    public function run()
    {
        if ($this->writable()) {
            try {
                if (!$this->client->ready()) {
                    throw new ClientInvalidSession();
                }

                $blogs = $this->client->call('blogs');
                $statuses = $this->statuses($blogs);
                $users = get_users(array(
                    'fields' => array('id', 'user_login'),
                ));

                $this->render('blogs', array(
                    'blogs' => $blogs,
                    'statuses' => $statuses,
                    'users' => $users,
                ));
            } catch (ClientErrorException $ex) {
                $this->gracefully_handle_exception($ex);
                die;
            } catch (ClientInvalidSession $ex) {
                $redirect = admin_url('admin.php?import=' . self::SLUG);

                if ($this->client->ready()) {
                    $response = $this->handled_call('reset', array(
                        'redirect' => $redirect,
                    ));

                    if (property_exists($response, 'status') && $response->status == 'done') {
                        $this->client->reset();
                    }
                }

                $response = $this->handled_call('init', array(
                    'redirect' => $redirect,
                    'site_url' => get_site_url()
                ));

                $this->render('authorize', array(
                    'url' => $response->url,
                ));
            }
        } else {
            $this->render('error');
        }
    }

    private function statuses($blogs)
    {
        $statuses = array();

        if (property_exists($blogs, 'items')) {
            foreach ($blogs->items as $blog) {
                $status = get_option(BIEImporter::STATUS_PREFIX . $blog->id);

                if ($status) {
                    $statuses[$blog->id] = $status;
                }
            }
        }

        return $statuses;
    }

    private function writable()
    {
        $upload = wp_upload_dir();

        return empty($upload['error']);
    }

    public function import()
    {

        $importer = new BIEImporter(sanitize_text_field($_POST['blog_id']));
        $status = $importer->import(isset($options) ? $options : array());

        die(json_encode($status));
    }

    public function status()
    {
        $importer = new BIEImporter(sanitize_text_field($_POST['blog_id']));
        $status = $importer->status();

        die(json_encode($status));
    }

    public function authors()
    {
        global $wpdb;

        foreach ($_POST['authors'] as $author) {
            if ($author['wordpress_login']) {
                $user_id = wp_insert_user(array(
                    'user_login' => sanitize_text_field($author['wordpress_login']),
                ));
            } else {
                $user_id = $author['wordpress_id'];
            }

            $user = get_user_by('id', $user_id);

            $wpdb->query($wpdb->prepare("
                       UPDATE `$wpdb->posts` `p`
                    LEFT JOIN `$wpdb->postmeta` `m`
                           ON `p`.`ID` = `m`.`post_id`
                          SET `p`.`post_author` = %d
                        WHERE `m`.`meta_key` = '" . BIEImporter::PREFIX . "author'
                          AND `m`.`meta_value` = %s", $user_id, sanitize_text_field($author['blogger_id'])));

            $wpdb->query($wpdb->prepare("
                       UPDATE `$wpdb->comments` `c`
                    LEFT JOIN `$wpdb->commentmeta` `m`
                           ON `c`.`comment_ID` = `m`.`comment_id`
                          SET `c`.`user_id` = %d,
                              `c`.`comment_author` = %s
                        WHERE `m`.`meta_key` = '" . BIEImporter::PREFIX . "author'
                          AND `m`.`meta_value` = %s", $user_id, $user->data->display_name, sanitize_text_field($author['blogger_id'])));
        }

        die();
    }

    public function unlock()
    {
        $importer = new BIEImporter(sanitize_text_field($_POST['blog_id']));
        $importer->unlock();

        die();
    }

    public function reset()
    {
        // // Ask server to clear user's token from DB
        $this->handled_call('reset');
        // Reset client cache
        $this->client->reset();

        die;
    }
}
