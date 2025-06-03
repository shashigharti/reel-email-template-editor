<?php

namespace ReelEmailTemplateEditor;

class Installer {
    public static function install() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'reel_email_templates';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            slug varchar(191) NOT NULL UNIQUE,
            title varchar(255) NOT NULL,
            subject varchar(255) NOT NULL,
            content longtext NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}
