<?php

if (!function_exists('reel_get_admin_user')) {
    function reel_get_admin_user()
    {
        $admins = get_users([
            'role'   => 'administrator',
            'number' => 1,
            'orderby' => 'ID',
            'order'   => 'ASC',
        ]);

        return $admins[0] ?? null;
    }
}
