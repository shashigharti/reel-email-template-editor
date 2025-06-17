<?php

namespace ReelEmailTemplateEditor\Database;

class HookSeeder {
    protected string $hooks_table;
    protected array $default_hooks;

    public function __construct(string $hooks_table, array $default_hooks) {
        $this->hooks_table = $hooks_table;
        $this->default_hooks = $default_hooks;
    }

    public function seed(){
        global $wpdb;
        foreach ($this->default_hooks as $hook) {
            $exists = (int) $wpdb->get_var(
                $wpdb->prepare("SELECT COUNT(*) FROM {$this->hooks_table} WHERE hook_name = %s", $hook['hook_name'])
            );

            if (!$exists) {
                $wpdb->insert(
                    $this->hooks_table,
                    [
                        'hook_name'   => $hook['hook_name'],
                        'name'        => $hook['name'],
                        'description' => $hook['description'],
                    ],
                    [
                        '%s',
                        '%s',
                        '%s',
                    ]
                );
            }
        }
    }
}
