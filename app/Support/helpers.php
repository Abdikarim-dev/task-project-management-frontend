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
