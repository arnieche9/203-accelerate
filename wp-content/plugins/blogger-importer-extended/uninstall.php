<?php
// If file not called from WordPress, bail.
if (!defined('WP_UNINSTALL_PLUGIN') || !WP_UNINSTALL_PLUGIN || dirname(WP_UNINSTALL_PLUGIN) != dirname(plugin_basename(__FILE__))) {
    status_header(404);
    die;
}

require 'includes/uninstaller.php';
BIEUninstaller::uninstall();