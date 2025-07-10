<?php
namespace ReelEmailTemplateEditor;

use ReelEmailTemplateEditor\Includes\EmailDispatcher;
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
    
        $this->register_hooks();
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

    public function enqueue_admin_scripts( $hook ) {
        if ( $hook !== $this->page_hook ) {
            return;
        }

        $plugin_file = __DIR__ . '/../reel-email-template.php';
        $plugin_dir  = plugin_dir_path( $plugin_file );
        $plugin_url  = plugin_dir_url( $plugin_file );

        $js_file  = 'build/admin.js';
        $css_file = 'build/admin.css';

        $js_path  = $plugin_dir . $js_file;
        $css_path = $plugin_dir . $css_file;

        $version = file_exists( $js_path ) ? filemtime( $js_path ) : false;

        wp_enqueue_script(
            'reel-email-template-editor-admin',
            $plugin_url . $js_file,
            [ 'wp-element', 'wp-components', 'wp-api-fetch', 'wp-block-editor' ],
            $version,
            true
        );

        if ( file_exists( $css_path ) ) {
            $css_version = filemtime( $css_path );
            wp_enqueue_style(
                'reel-email-template-editor-admin-style',
                $plugin_url . $css_file,
                ['wp-components' ],
                $css_version
            );
        }
    }

    public function register_placeholders() {
        // Register dummy variables.
        add_action('reel_email_placeholders_register', [$this, 'register_dummy_placeholders']);


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

    public function register_dummy_placeholders() {
        $placeholders = require plugin_dir_path(__FILE__) . 'config/dummy.php';

        foreach ($placeholders as $key => $value) {
            PlaceholderRegistry::register($key, function () use ($value) {
                return $value;
            });
        }
    }

    public function register_hooks(){
        $hooks = require __DIR__ . '/config/hooks.php';
        foreach($hooks as $hook_data){
            $hook_name = $hook_data['hook_name'];
            add_filter($hook_name, function($result, $to, $context = []) use ($hook_name) {
                if (empty($to)) {
                    return new \WP_Error('no_to', 'No recipient provided.');
                }
                $dispatcher = new EmailDispatcher();

                // Prepares the template based on context and sends email.
                $dispatcher->dispatch($hook_name, $to, $context);
            }, 10, 3);
        }
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
