<?php
namespace ReelEmailTemplateEditor\Includes;

class PlaceholderRegistry {
    protected static array $placeholders = [];

    public static function register(string $key, callable $callback): void {
        self::$placeholders[$key] = $callback;
    }

    public static function resolve(string $key, $context): string {
        if (isset(self::$placeholders[$key]) && is_callable(self::$placeholders[$key])) {
            return (string) call_user_func(self::$placeholders[$key], $context);
        }
        return '';
    }

    public static function resolve_all(string $template, array $context = []): string {
        return preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($context) {
            $key = trim($matches[1]);
            return self::resolve($key, $context);
        }, $template);
    }

    public static function list(): array {
        return array_keys(self::$placeholders);
    }
}
