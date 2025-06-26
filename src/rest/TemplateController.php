<?php
namespace ReelEmailTemplateEditor\Rest;

use ReelEmailTemplateEditor\Includes\TemplateRepository;
use ReelEmailTemplateEditor\Includes\EmailService;
use ReelEmailTemplateEditor\Includes\PlaceholderRegistry;
use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

class TemplateController extends WP_REST_Controller {
    protected $namespace = 'reel/v1';

    public function register_routes() {

        register_rest_route($this->namespace, '/email/send', [
            'methods'  => 'POST',
            'callback' => [$this, 'send_test_email'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route($this->namespace, '/template/import', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'import_template'],
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
            'args' => [], 
        ]);

        register_rest_route($this->namespace, '/templates', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_templates'],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]);

        register_rest_route($this->namespace, '/template/(?P<id>[a-zA-Z0-9_-]+)', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_template'],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]);

        register_rest_route($this->namespace, '/template/(?P<id>[a-zA-Z0-9_-]+)', [
            'methods' => WP_REST_Server::DELETABLE,
            'callback' => [$this, 'delete_template'],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]);

        register_rest_route($this->namespace, '/template/(?P<id>[a-zA-Z0-9_-]+)', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'save_template'],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            },
            'args' => [
                'content' => [
                    'required' => true,
                ],
            ],
        ]);  
        
        register_rest_route($this->namespace, '/variables', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_variable_list'],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]);
        
    }

    public function get_templates() {
        $templates = array_map(function($template) {
            return [
                'id' => $template['id'],
                'title' => $template['title'],
                'slug' => $template['slug'],
                'subject' => $template['subject'] ?? null,
                'user_type' => $template['user_type'] ?? null,
                'created_at' => $template['created_at'] ?? null,
                'updated_at' => $template['updated_at'] ?? null,
            ];
        }, TemplateRepository::get_templates());

        return new WP_REST_Response($templates, 200);
    }

    public function get_template(WP_REST_Request $request) {
        $slug = $request->get_param('id');
        $template = TemplateRepository::get_template_by_slug($slug);

        if (!$template) {
            return new WP_REST_Response(['message' => 'Template not found'], 404);
        }

        return new WP_REST_Response($template, 200);
    }

    public function save_template(WP_REST_Request $request) {
        $id = $request->get_param('id');
        $params = $request->get_params();

        if (!TemplateRepository::get_template_by_id($id)) {
            return new WP_REST_Response(['message' => 'Template not found'], 404);
        }

        TemplateRepository::save_template($id, $params);

        return new WP_REST_Response(['message' => 'Template saved'], 200);
    }

    public function import_template(WP_REST_Request $request) {
        $templates_dir = plugin_dir_path(__FILE__) . '../templates/';
        $imported = [];
        $errors = [];

        if (!is_dir($templates_dir)) {
            return new WP_REST_Response(['message' => 'Templates folder not found'], 500);
        }

        $files = glob($templates_dir . '*.html');

        foreach ($files as $file) {
            $filename = basename($file, '.html');

            if ($filename === 'default') {
                continue;
            }

            $content = file_get_contents($file);
            if (!$content) {
                $errors[] = "Failed to read file: " . basename($file);
                continue;
            }

            $slug = sanitize_title($filename);
            $title = ucwords(str_replace(['-', '_'], ' ', $slug));

            $existing = TemplateRepository::template_exists($slug);
            if ($existing) {
                $errors[] = "Template already exists: " . $slug;
                continue;
            }

            $result = TemplateRepository::insert_template($title, $slug, $content);
            if ($result) {
                $imported[] = $slug;
            } else {
                $errors[] = "Failed to import template: " . $slug;
            }
        }

        return new WP_REST_Response([
            'imported' => $imported,
            'errors' => $errors
        ], empty($errors) ? 200 : 207);
    }

    public function delete_template(WP_REST_Request $request) {
        $id = $request->get_param('id');

        $template = TemplateRepository::template_exists($id);
        if (!$template) {
            return new WP_REST_Response(['message' => 'Template not found'], 404);
        }

        $deleted = TemplateRepository::delete_template($id);

        if ($deleted) {
            return new WP_REST_Response(['message' => 'Template deleted'], 200);
        } else {
            return new WP_REST_Response(['message' => 'Failed to delete template'], 500);
        }
    }

    public function send_test_email(WP_REST_Request $request) {
        $to        = $request->get_param('recipient_email');
        $subject        = "Test Email from Reel-to-Reel";

        if (empty($to) || empty($subject)) {
            return new WP_REST_Response(['message' => 'Missing required parameters'], 400);
        }

        $template = TemplateRepository::get_template_by_slug('default');
        if (!$template) {
            return new WP_REST_Response(['message' => 'Template not found'], 404);
        }

        $template_content = $template['content'];

        $context = [];
        $user =  get_user_by( 'email', $to );        

        if (!$user) {
            return new WP_REST_Response(['message' => 'User not found'], 404);
        }

        $context['user'] = $user; 
        $content = PlaceholderRegistry::resolve_all($template_content, $context);

        $email_service = new EmailService();
        $result = $email_service->send_email($to, $subject, $content);

        if (is_wp_error($result)) {
            return new WP_REST_Response(['message' => $result->get_error_message()], 500);
        }

        return new WP_REST_Response(['message' => 'Email sent successfully'], 200);
    }

    public function get_variable_list() {
        $variables_file = plugin_dir_path(__FILE__) . '../config/variables.php';

        if (!file_exists($variables_file)) {
            return new WP_REST_Response(['message' => 'Variable list not found'], 500);
        }

        $variables = include $variables_file;

        return new WP_REST_Response($variables, 200);
    }

}
