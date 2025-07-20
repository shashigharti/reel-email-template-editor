<?php

namespace ReelEmailTemplateEditor\Includes;

class EmailService {
    
    public function get_template_content( int $template_id ): string {
        $post = get_post( $template_id );

        return $post ? $post->post_content : '';
    }

    public function send_email(string $to, string $subject, string $body)
    {
        $template_path = plugin_dir_path(__FILE__) . 'templates/default-email.php';

        if (!file_exists($template_path)) {
            return new \WP_Error(
                'template_missing',
                __('Email template not found', 'reel-email-template-editor')
            );
        }

        ob_start();
        include $template_path;
        $template_content = ob_get_clean();

        $final_body = str_replace(
            ['{{email_body}}', '{{email_subject}}'],
            [$body, $subject],
            $template_content
        );

        $headers = ['Content-Type: text/html; charset=UTF-8'];
        $headers[] = 'From: Reel-Reel <no-reply@reel-reel.com>';

        $result = wp_mail($to, $subject, $final_body, $headers);

        if (!$result) {
            return new \WP_Error(
                'send_failed',
                __('Failed to send email', 'reel-email-template-editor')
            );
        }

        return true;
    }

}
