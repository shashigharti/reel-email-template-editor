<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;
$table_templates = $wpdb->prefix . 'reel_email_templates';
$table_hooks = $wpdb->prefix . 'reel_hooks';

$wpdb->query("DROP TABLE IF EXISTS `{$table_templates}`");
$wpdb->query("DROP TABLE IF EXISTS `{$table_hooks}`");