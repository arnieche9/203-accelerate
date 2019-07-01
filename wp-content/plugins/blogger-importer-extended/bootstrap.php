<?php
/*
Plugin Name: Blogger Importer Extended
Plugin URI: https://wordpress.org/plugins/blogger-importer-extended/
Description: Transfer all your posts, pages, comments and labels to WordPress.
Author: pipdig
Version: 1.3.3
Author URI: https://www.pipdig.co/
Text Domain: blogger-importer-extended
*/

if (!defined('ABSPATH')) die;

define('BIE_DIR', dirname(__FILE__));

require(BIE_DIR . '/includes/template.php');
require(BIE_DIR . '/includes/importer.php');
require(BIE_DIR . '/includes/client.php');
require(BIE_DIR . '/includes/core.php');
/*
if (!function_exists('redirect_to')) {
	require(BIE_DIR . '/includes/redirects.php');
}
*/

register_activation_hook(__FILE__, array('BIECore', 'install'));

$bie_core = new BIECore(__FILE__);
$bie_core->load();