<?php

namespace ReelEmailTemplateEditor\Includes;

class TemplateRepository {
    protected static $table_name;

    protected static function get_table_name() {
        global $wpdb;
        if (!self::$table_name) {
            self::$table_name = $wpdb->prefix . 'reel_email_templates';
        }
        return self::$table_name;
    }

    public static function get_templates() {
        global $wpdb;
        $table = self::get_table_name();

        $templates = $wpdb->get_results("SELECT * FROM $table ORDER BY id ASC", ARRAY_A);

        if (empty($templates)) {
            return [self::get_default_template()];
        }

        return $templates;
    }

    public static function template_exists($identifier) {
        global $wpdb;
        $table = self::get_table_name();

        if (empty($identifier)) {
            return false;
        }

        if (is_numeric($identifier)) {
            $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE id = %d", intval($identifier)));
            if ($exists) {
                return true;
            }
        }

        return (bool) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE slug = %s", sanitize_text_field($identifier)));
    }


    public static function get_template_by_slug($slug) {
        global $wpdb;
        $table = self::get_table_name();

        if ($slug === 'default') {
            return self::get_default_template();
        }

        $template = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table WHERE slug = %s LIMIT 1", $slug),
            ARRAY_A
        );

        if ($template) {
            if (empty($template['content'])) {
                $template['content'] = self::load_template_file($slug . '.html');
            }
            return $template;
        }

        $file_content = self::load_template_file($slug . '.html');
        if ($file_content) {
            return [
                'id' => 0,
                'slug' => $slug,
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'content' => $file_content,
                'created_at' => null,
                'updated_at' => null,
            ];
        }

        return null;
    }

    public static function get_template_by_id($id) {
        global $wpdb;
        $table = self::get_table_name();

        if ($id === 'default') {
            return self::get_default_template();
        }

        $template = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table WHERE slug = %s LIMIT 1", $id),
            ARRAY_A
        );

        if ($template) {
            if (empty($template['content'])) {
                $template['content'] = self::load_template_file($id . '.html');
            }
            return $template;
        }

        $file_content = self::load_template_file($id . '.html');
        if ($file_content) {
            return [
                'id' => 0,
                'slug' => $id,
                'title' => ucwords(str_replace('-', ' ', $id)),
                'content' => $file_content,
                'created_at' => null,
                'updated_at' => null,
            ];
        }

        return null;
    }

    public static function save_template($id, $params){
        global $wpdb;
        $table = self::get_table_name();

        $data = [
            'content' => $params['content'],
            'slug' => $params['slug'],
            'subject' => $params['subject'],
            'title' => $params['title'],
            'description' => $params['description'] ?? '',
            'hook_id' => $params['hook_id'] ?? null,
            'updated_at' => current_time('mysql'),
        ];
        
        if (empty($id)) {
            $data['created_at'] = current_time('mysql');
            $inserted = $wpdb->insert(
                $table,
                $data,
                ['%s', '%s', '%s', '%s', '%s', '%s']
            );
            return $inserted !== false;
        }

        $updated = $wpdb->update(
            $table,
            $data,
            ['id' => $id],
            ['%s', '%s', '%s', '%s', '%s', '%s'],
            ['%d']
        );

        return $updated !== false;
    }

    protected static function load_template_file($filename) {
        $template_path = plugin_dir_path(__DIR__) . 'templates/' . $filename;
        if (file_exists($template_path)) {
            return file_get_contents($template_path);
        }
        return $template_path;
    }

    public static function get_default_template() {
        return [
            'id' => 0,
            'slug' => 'default',
            'title' => 'Default Template',
            'content' => self::load_template_file('default.html'),
            'created_at' => null,
            'updated_at' => null,
        ];
    }

    public static function insert_template($title, $slug, $content = '', $subject = '') {
        global $wpdb;
        $table = self::get_table_name();

        $wpdb->insert(
            $table,
            [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'subject' => $subject,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ],
            ['%s', '%s', '%s', '%s', '%s']
        );
        return $wpdb->insert_id;
    }

    public static function delete_template($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'reel_email_templates';

        $result = $wpdb->delete($table, ['id' => $id], ['%d']);

        return $result !== false;
    }

}
