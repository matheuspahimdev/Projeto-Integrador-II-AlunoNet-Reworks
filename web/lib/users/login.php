<?php

declare(strict_types=1);

$routes = require dirname(__DIR__, 3) . '/config/routes.php';
require_once dirname(__DIR__) . '/auth.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: /pages/auth/login.php');
    exit;
}

$registration = trim((string) ($_POST['registration'] ?? ''));
$password = (string) ($_POST['password'] ?? '');

if ($registration === '' || $password === '') {
    setAuthError('Informe sua matrícula e sua senha.', $registration);
    header('Location: /pages/auth/login.php');
    exit;
}

$user = $routes['users']->authenticate($registration, $password);

if ($user === null) {
    setAuthError('Matrícula ou senha inválida.', $registration);
    header('Location: /pages/auth/login.php');
    exit;
}

authenticateSession($user);
header('Location: /index.php');
exit;