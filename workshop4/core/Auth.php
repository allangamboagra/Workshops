<?php

/**
 * Manejo de la sesión del usuario autenticado y de la cookie "Remember me"
 */
class Auth
{
    // Las sesiones inactivas por más de este tiempo se consideran expiradas
    const SESSION_TIMEOUT_SECONDS = 30 * 60;

    const REMEMBER_COOKIE = 'remembered_username';

    public static function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // Guarda en la sesión los datos del usuario autenticado
    public static function login(array $user): void
    {
        self::startSession();
        // Evita session fixation generando un id de sesión nuevo al iniciar sesión
        session_regenerate_id(true);

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['last_activity'] = time();
        self::refresh($user);
    }

    // Mantiene la sesión sincronizada con los datos del usuario (por ejemplo, tras editar el perfil)
    public static function refresh(array $user): void
    {
        $_SESSION['username'] = $user['username'];
        $_SESSION['province_id'] = $user['province_id'] !== null ? (int) $user['province_id'] : null;
        $_SESSION['province_name'] = $user['province_name'];
        $_SESSION['profile_picture'] = $user['profile_picture'];
    }

    public static function logout(): void
    {
        self::startSession();
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
    }

    // Redirige al login a menos que exista una sesión válida y activa
    public static function requireLogin(): void
    {
        self::startSession();

        if (!isset($_SESSION['user_id'])) {
            redirect('login', ['error' => 'login_required']);
        }

        if (time() - ($_SESSION['last_activity'] ?? 0) > self::SESSION_TIMEOUT_SECONDS) {
            self::logout();
            redirect('login', ['error' => 'session_expired']);
        }

        $_SESSION['last_activity'] = time();
    }

    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    // Datos del usuario en sesión, listos para pasarlos a una vista
    public static function user(): array
    {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? '',
            'province_id' => $_SESSION['province_id'] ?? null,
            'province_name' => $_SESSION['province_name'] ?? null,
            'profile_picture' => $_SESSION['profile_picture'] ?? null,
        ];
    }

    public static function rememberedUsername(): string
    {
        return $_COOKIE[self::REMEMBER_COOKIE] ?? '';
    }

    public static function isRemembering(): bool
    {
        return isset($_COOKIE[self::REMEMBER_COOKIE]);
    }

    public static function rememberUsername(string $username): void
    {
        setcookie(self::REMEMBER_COOKIE, $username, [
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    public static function forgetUsername(): void
    {
        setcookie(self::REMEMBER_COOKIE, '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}
