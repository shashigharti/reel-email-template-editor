<?php
namespace ReelEmailTemplateEditor\Rest;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

use ReelEmailTemplateEditor\Includes\HookRepository;

class HookController extends WP_REST_Controller {
    protected $namespace = 'reel/v1';
    protected $base = 'hooks';

    protected HookRepository $repository;

    public function __construct() {
        global $wpdb;
        $this->repository = new HookRepository($wpdb);
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/' . $this->base, [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_all_hooks'],
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);

        register_rest_route($this->namespace, '/' . $this->base . '/(?P<id>\d+)', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_hook_by_id'],
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
            'args' => [
                'id' => [
                    'required' => true,
                    'validate_callback' => 'is_numeric',
                ],
            ],
        ]);
    }

    public function get_all_hooks(WP_REST_Request $request): WP_REST_Response {
        $hooks = $this->repository->get_all();
        return new WP_REST_Response($hooks, 200);
    }

    public function get_hook_by_id(WP_REST_Request $request): WP_REST_Response {
        $id = (int) $request->get_param('id');
        $hook = $this->repository->get_by_id($id);

        if (!$hook) {
            return new WP_REST_Response(['message' => 'Hook not found'], 404);
        }

        return new WP_REST_Response($hook, 200);
    }
}
