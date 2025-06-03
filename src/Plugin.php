<?php
namespace ReelEmailTemplateEditor;

use ReelEmailTemplateEditor\Rest\TemplateController;

class Plugin {
    private $page_hook;

    public function register() {
        add_action('rest_api_init', [$this, 'registerRestRoutes']);
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
    }

    public function registerRestRoutes() {
        $controller = new TemplateController();
        $controller->register_routes();
    }

    public function addAdminMenu() {
        $this->page_hook = add_menu_page(
            'Reel Email Editor',
            'Reel Email Editor',
            'manage_options',
            'reel-email-template-editor',
            [$this, 'adminPageHtml'],
            'dashicons-email-alt',
            20
        );
    }

    public function enqueueAdminScripts($hook) {
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

    public function adminPageHtml() {
        ?>
        <div class="wrap">
            <h1>Reel Email Template Editor</h1>
            <div id="reel-email-template-editor-root"></div>
        </div>
        <?php
    }
}
