<?php

namespace App\Support;

class AuthSession
{
    private const TOKEN_KEY = 'api_token';

    private const USER_KEY = 'auth_user';

    public static function user(): ?array
    {
        $user = session(self::USER_KEY);

        return is_array($user) ? $user : null;
    }

    public static function token(): ?string
    {
        return session(self::TOKEN_KEY);
    }

    public static function check(): bool
    {
        return self::token() !== null && self::user() !== null;
    }

    public static function isAdmin(): bool
    {
        return (self::user()['role'] ?? null) === 'admin';
    }

    public static function login(string $token, array $user): void
    {
        session([
            self::TOKEN_KEY => $token,
            self::USER_KEY => $user,
        ]);
    }

    public static function logout(): void
    {
        session()->forget([self::TOKEN_KEY, self::USER_KEY]);
    }

    public static function updateUser(array $user): void
    {
        session([self::USER_KEY => $user]);
    }
}
