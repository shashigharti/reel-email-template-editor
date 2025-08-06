<?php

namespace ReelEmailTemplateEditor;

use ReelEmailTemplateEditor\Database\HookSeeder;

class Installer {
    public static function install() {
        global $wpdb;

        $hooks_table = $wpdb->prefix . 'reel_hooks';
        $templates_table = $wpdb->prefix . 'reel_email_templates';
        $charset_collate = $wpdb->get_charset_collate();

        $hooks_sql = "CREATE TABLE $hooks_table (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            hook_name varchar(191) NOT NULL UNIQUE,
            theme varchar(191) NULL,
            name varchar(191) NOT NULL,
            description text NULL,            
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $templates_sql = "CREATE TABLE $templates_table (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            hook_id bigint(20) unsigned DEFAULT NULL,
            slug varchar(191) NOT NULL UNIQUE,
            title varchar(255) NOT NULL,
            subject varchar(255) NOT NULL,
            content longtext NOT NULL,
            description text NULL,
            user_type varchar(255) DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id),
            KEY hook_id (hook_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($hooks_sql);
        dbDelta($templates_sql);

        $wpdb->query("
            ALTER TABLE $templates_table
            ADD CONSTRAINT fk_hook_id
            FOREIGN KEY (hook_id)
            REFERENCES $hooks_table(id)
            ON DELETE SET NULL
        ");

        $default_hooks = require __DIR__ . '/config/hooks.php';
        $seeder = new HookSeeder($hooks_table, $default_hooks);
        $seeder->seed();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}
