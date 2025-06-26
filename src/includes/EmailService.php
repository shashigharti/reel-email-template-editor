<?php

namespace ReelEmailTemplateEditor\Includes;

class EmailService {
    
    public function get_template_content( int $template_id ): string {
        $post = get_post( $template_id );

        return $post ? $post->post_content : '';
    }

    public function send_email(string $to, string $subject, string $body) {        

        $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
        $headers[] = 'From: Reel-Reel <no-reply@reel-reel.com>';

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
