<?php

namespace ReelEmailTemplateEditor\Includes;

class EmailDispatcher {

    protected $wpdb;
    protected $hooks_table;
    protected $templates_table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->hooks_table = $wpdb->prefix . 'reel_hooks';
        $this->templates_table = $wpdb->prefix . 'reel_email_templates';
    }

    public function dispatch(string $hook_name, array $context = []) {
        $hook = $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT * FROM {$this->hooks_table} WHERE hook_name = %s", $hook_name)
        );

        if (!$hook) {
            error_log("Dispatch failed: Hook '$hook_name' not found.");
            return new \WP_Error('hook_not_found', "No hook registered with name '$hook_name'.");        
        }

        $templates = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->templates_table} 
                 WHERE hook_id = %d",
                $hook->id
            )
        );

        if (!$templates) {
            error_log("Dispatch failed: No template found for hook '$hook_name'.");
            return new \WP_Error('template_not_found', "No email template found for hook '$hook_name'.");
        }

        $email_service = new EmailService();
        foreach ($templates as $template) {
            $subject = PlaceholderRegistry::resolve_all($template->subject, $context);
            $body    = PlaceholderRegistry::resolve_all($template->content, $context);
            $to = $context['data'][$template->user_type];

            $result = $email_service->send_email($to, $subject, $body);

            if (is_wp_error($result)) {
                error_log("Email dispatch error for hook '$hook_name': " . $result->get_error_message());
            }
        }

        return true; 
    }
}
