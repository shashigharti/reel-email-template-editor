<?php

namespace ReelEmailTemplateEditor\Includes;

use ReelEmailTemplateEditor\Includes\PlaceholderRegistry;

class EmailService {
    
    public function get_template_content( int $template_id ): string {
        $post = get_post( $template_id );

        return $post ? $post->post_content : '';
    }

    public function send_email(string $to, string $subject, string $template_html, array $context = []) {
        $body = PlaceholderRegistry::resolve_all($template_html, $context);

        $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

        $result = wp_mail($to, $subject, $body, $headers);

        if (!$result) {
            return new \WP_Error(
                'send_failed',
                __('Failed to send email', 'reel-email-template-editor')
            );
        }

        return true;
    }
}
