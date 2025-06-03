<?php
/**
 * Plugin Name: Reel Email Template Editor
 * Description: Email template editor plugin.
 * Version: 1.0.0
 * Author: Reel Reel
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/vendor/autoload.php';

use ReelEmailTemplateEditor\Plugin;
use ReelEmailTemplateEditor\Installer;

register_activation_hook(__FILE__, [Installer::class, 'install']);
register_deactivation_hook(__FILE__, [Installer::class, 'deactivate']);

function ReelEmailTemplateEditorInit() {
    $plugin = new Plugin();
    $plugin->register();
}
add_action('plugins_loaded', 'ReelEmailTemplateEditorInit');
