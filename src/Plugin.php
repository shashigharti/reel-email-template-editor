<?php
namespace ReelEmailTemplateEditor;

use ReelEmailTemplateEditor\Rest\TemplateController;
use ReelEmailTemplateEditor\Rest\HookController;
use ReelEmailTemplateEditor\Includes\PlaceholderRegistry;

class Plugin {
    private $page_hook;
    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register() {
        $this->register_placeholders();

        add_action('rest_api_init', [$this, 'register_rest_routes']);
        add_action('wp_loaded', [$this, 'register_placeholders']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function register_rest_routes() {
        $template_controller = new TemplateController();
        $template_controller->register_routes();

        $hook_controller = new HookController();
        $hook_controller->register_routes();
    }

    public function add_admin_menu() {
        $this->page_hook = add_menu_page(
            'Reel Email Editor',
            'Reel Email Editor',
            'manage_options',
            'reel-email-template-editor',
            [$this, 'admin_page_html'],
            'dashicons-email-alt',
            20
        );
    }

    public function enqueue_admin_scripts($hook) {
        if ($hook !== $this->page_hook) {
            return;
        }

        $buildFilePath = dirname(__DIR__) . '/build/admin.js';

        $version = file_exists($buildFilePath) ? filemtime($buildFilePath) : false;

        wp_enqueue_script(
            'reel-email-template-editor-admin',
            plugins_url('build/admin.js', plugin_dir_path(__DIR__) . 'reel-email-template-editor.php'),
            ['wp-element', 'wp-components', 'wp-api-fetch', 'wp-block-editor'],
            $version,
            true
        );

        wp_enqueue_style('wp-components');
    }

    public function register_placeholders() {
        do_action('reel_email_placeholders_register');

        PlaceholderRegistry::register('firstname', function ($context) {
            return $context['user']->first_name ?? '';
        });

        PlaceholderRegistry::register('username', function ($context) {
            return $context['user']->user_login ?? '';
        });

        PlaceholderRegistry::register('admin', function ($context) {
            return 'Reel-to-reel Admin';
        });
        
    }

    public function admin_page_html() {
        ?>
        <div class="wrap">
            <h1>Reel Email Template Editor</h1>
            <div id="reel-email-template-editor-root"></div>
        </div>
        <?php
    }
}
