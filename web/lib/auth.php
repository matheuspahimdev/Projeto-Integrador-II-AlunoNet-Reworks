<?php

declare(strict_types=1);

function startAppSession(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function authenticateSession(array $user): void
{
    startAppSession();
    session_regenerate_id(true);
    $_SESSION['authenticated_user'] = $user;
}

function currentAuthenticatedUser(): ?array
{
    startAppSession();

    $user = $_SESSION['authenticated_user'] ?? null;

    return is_array($user) ? $user : null;
}

function requireAuthenticatedUser(): array
{
    $user = currentAuthenticatedUser();

    if ($user === null) {
        header('Location: /pages/auth/login.php');
        exit;
    }

    return $user;
}

function logoutSession(): void
{
    startAppSession();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

function setAuthError(string $message, string $registration = ''): void
{
    startAppSession();
    $_SESSION['auth_error'] = $message;
    $_SESSION['auth_registration'] = $registration;
}

function consumeAuthError(): ?array
{
    startAppSession();
    $error = $_SESSION['auth_error'] ?? null;
    $registration = $_SESSION['auth_registration'] ?? '';
    unset($_SESSION['auth_error'], $_SESSION['auth_registration']);

    return is_string($error) ? ['message' => $error, 'registration' => (string) $registration] : null;
}