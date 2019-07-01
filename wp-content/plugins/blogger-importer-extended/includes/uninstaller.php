<?php if (!defined('ABSPATH')) die;

class BIEUninstaller
{
    public static function uninstall()
    {
        // Delete all bie_* options
        $option_prefix = 'bie_%';
        global $wpdb;
        $query = "DELETE FROM {$wpdb->options} WHERE option_name like '{$option_prefix}'";
        $wpdb->query($query);
    }
}