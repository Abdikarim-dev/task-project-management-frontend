<?php

use App\Support\AuthSession;

if (! function_exists('auth_user')) {
    function auth_user(): ?array
    {
        return AuthSession::user();
    }
}

if (! function_exists('auth_check')) {
    function auth_check(): bool
    {
        return AuthSession::check();
    }
}

if (! function_exists('auth_is_admin')) {
    function auth_is_admin(): bool
    {
        return AuthSession::isAdmin();
    }
}

if (! function_exists('user_theme')) {
    function user_theme(): string
    {
        $theme = auth_user()['theme_preference'] ?? 'light';

        return in_array($theme, ['light', 'dark'], true) ? $theme : 'light';
    }
}
