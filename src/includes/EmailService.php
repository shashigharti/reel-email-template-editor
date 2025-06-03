<?php

namespace ReelEmailTemplateEditor\Includes;

class EmailService {

    public function getTemplateContent(int $templateId): string {
        $post = get_post($templateId);
        return $post ? $post->post_content : '';
    }


    public function replaceVariables(string $templateHtml, array $variables = []): string {
        $globalVars = get_option('reel_email_variables', []);
        $allVars = array_merge($globalVars, $variables);

        foreach ($allVars as $key => $value) {
            $templateHtml = str_replace('{{' . $key . '}}', esc_html($value), $templateHtml);
        }

        return $templateHtml;
    }

    public function sendEmail(string $to, string $subject, string $templateHtml, array $variables = []): bool|\WP_Error {
        $body = $this->replaceVariables($templateHtml, $variables);

        $headers = ['Content-Type: text/html; charset=UTF-8'];

        $result = wp_mail($to, $subject, $body, $headers);

        if (!$result) {
            return new \WP_Error('send_failed', __('Failed to send email', 'reel-email-template-editor'));
        }

        return true;
    }
}
