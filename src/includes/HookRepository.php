<?php

namespace ReelEmailTemplateEditor\Includes;

use wpdb;

class HookRepository {
    protected wpdb $db;
    protected string $table;

    public function __construct(wpdb $db) {
        $this->db = $db;
        $this->table = $this->db->prefix . 'reel_hooks';
    }

    public function get_all(): array {
        $query = "SELECT * FROM {$this->table} ORDER BY name ASC";
        return $this->db->get_results($query, ARRAY_A);
    }

    public function get_by_id(int $id): ?array {
        $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = %d", $id);
        $result = $this->db->get_row($query, ARRAY_A);
        return $result ?: null;
    }
}
