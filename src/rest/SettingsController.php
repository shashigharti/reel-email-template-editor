<?php

namespace ReelEmailTemplateEditor\Rest;

use WP_REST_Request;
use WP_REST_Response;

class SettingsController
{
    const OPTION_PREFIX = 'reel_email_template_editor_settings';
    const REST_NAMESPACE = 'reel/v1';
    const REST_ROUTE = 'settings';

    public function register_routes()
    {
        register_rest_route(self::REST_NAMESPACE, '/' . self::REST_ROUTE, [
            'methods'  => 'GET',
            'callback' => [$this, 'get_settings'],
            'permission_callback' => '__return_true',
            'args' => [
                'type' => [
                    'required' => true,
                    'type'     => 'string',
                    'sanitize_callback' => 'sanitize_key',
                ],
            ],
        ]);

        register_rest_route(self::REST_NAMESPACE, '/' . self::REST_ROUTE, [
            'methods'  => 'POST',
            'callback' => [$this, 'save_settings'],
            'permission_callback' => '__return_true',
            'args' => [
                'type' => [
                    'required' => true,
                    'type'     => 'string',
                    'sanitize_callback' => 'sanitize_key',
                ],
                'settings' => [
                    'required' => true,
                    'type'     => 'object',
                    'sanitize_callback' => [$this, 'sanitize_settings'],
                ],
            ],
        ]);
    }

    public function get_settings(WP_REST_Request $request)
    {
        $type = $request->get_param('type');
        $option_key = self::OPTION_PREFIX . $type;
        $settings = get_option($option_key, []);

        return new WP_REST_Response([
            'success' => true,
            'data'    => [
                'type'     => $type,
                'settings' => $settings,
            ],
        ], 200);
    }

    public function save_settings(WP_REST_Request $request)
    {
        $type = $request->get_param('type');
        $settings = $request->get_param('settings');

        if (!is_array($settings)) {
            return new WP_REST_Response([
                'success' => false,
                'error'   => 'Settings must be an object.',
            ], 400);
        }

        $option_key = self::OPTION_PREFIX . $type;
        update_option($option_key, $settings);

        return new WP_REST_Response([
            'success' => true,
            'data'    => [
                'message'  => 'Settings saved successfully.',
                'type'     => $type,
                'settings' => $settings,
            ],
        ], 200);
    }

    public function sanitize_settings($settings)
    {
        if (!is_array($settings)) return [];

        foreach ($settings as $key => &$value) {
            if (is_array($value)) {
                $value = $this->sanitize_settings($value);
            } else {
                $value = sanitize_text_field($value);
            }
        }

        return $settings;
    }
}
