<?php
/**
 * Plugin Name: Reel Email Template Editor
 * Description: Email template editor plugin.
 * Version: 1.0.0
 * Author: Reel Reel
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/includes/helpers.php';

use ReelEmailTemplateEditor\Plugin;
use ReelEmailTemplateEditor\Installer;

register_activation_hook(__FILE__, [Installer::class, 'install']);
register_deactivation_hook(__FILE__, [Installer::class, 'deactivate']);

function reel_email_template_editor_init() {
    Plugin::getInstance()->register();
}
add_action('plugins_loaded', 'reel_email_template_editor_init');
