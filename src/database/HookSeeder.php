<?php

namespace ReelEmailTemplateEditor\Database;

class HookSeeder {
    public static function seed() {
        global $wpdb;

        $table = $wpdb->prefix . 'reel_hooks';

        $default_hooks = [
            [
                'hook_name' => 'user_registered',
                'name' => 'User Registered',
                'description' => 'Triggered when a new user registers.'
            ],
            [
                'hook_name' => 'order_completed',
                'name' => 'Order Completed',
                'description' => 'Triggered when an order is marked as completed.'
            ],
            [
                'hook_name' => 'password_reset',
                'name' => 'Password Reset',
                'description' => 'Triggered when a user resets their password.'
            ]
        ];

        foreach ($default_hooks as $hook) {
            $exists = $wpdb->get_var(
                $wpdb->prepare("SELECT COUNT(*) FROM $table WHERE name = %s", $hook['name'])
            );

            if (!$exists) {
                $wpdb->insert($table, [
                    'hook_name'    => $hook['hook_name'],
                    'name'         => $hook['name'],
                    'description'  => $hook['description']
                ]);
            }
        }
    }
}
