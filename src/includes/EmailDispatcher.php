<?php

namespace ReelEmailTemplateEditor\Includes;

use ReelEmailTemplateEditor\Includes\PlaceholderRegistry;

class EmailDispatcher {

    protected $wpdb;
    protected $hooks_table;
    protected $templates_table;
    protected $placeholder_registry;

    public function __construct(PlaceholderRegistry $placeholder_registry) {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->hooks_table = $wpdb->prefix . 'reel_hooks';
        $this->templates_table = $wpdb->prefix . 'reel_email_templates';
        $this->placeholder_registry = $placeholder_registry ?: new PlaceholderRegistry();
    }

    public function dispatch(string $hookName, string $to, array $context = [], string $variantKey = 'default') {
        $hook = $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT * FROM {$this->hooks_table} WHERE hook_name = %s", $hookName)
        );

        if (!$hook) {
            return;
        }

        $templates = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->templates_table} 
                 WHERE hook_id = %d AND variant_key = %s 
                 ORDER BY is_default DESC LIMIT 1",
                $hook->id,
                $variantKey
            )
        );

        if (!$templates) {
            return;
        }

        $results = [];
        foreach ($templates as $template) {
            $subject = $this->placeholder_registry->resolve($template->subject, $context);
            $content = $this->placeholder_registry->resolve($template->content, $context);

            $email_service = new EmailService();
            $results[] = $email_service->send_email($to, $subject, $content, $context);
        }

        return $results;
    }
}
