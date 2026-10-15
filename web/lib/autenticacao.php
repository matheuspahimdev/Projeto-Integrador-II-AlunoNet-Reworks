<?php
require_once __DIR__ . '/dados.php';
require_once __DIR__ . '/navegacao.php';

const INSTITUTIONAL_SITE_URL = 'https://www.unifio.edu.br';

const LOGIN_PATH = 'pages/auth/login.php';

const REGISTRATION_PATTERN = '\d{4,10}';

// Mensagens usadas pelo PHP e pelo JS da tela de login.
const LOGIN_MESSAGES = [
    'registration_required' => 'Informe sua matrícula.',
    'registration_invalid' => 'A matrícula deve conter apenas números (4 a 10 dígitos).',
    'password_required' => 'Informe sua senha.',
    'invalid_fields' => 'Não foi possível entrar. Verifique os campos destacados.',
    'wrong_credentials' => 'Matrícula ou senha incorretas.',
];

const LOGIN_HIGHLIGHTS = [
    ['icon' => 'bi-journal-check', 'text' => 'Notas, faltas e horários em um só lugar'],
    ['icon' => 'bi-receipt', 'text' => 'Boletos e extrato financeiro sempre à mão'],
    ['icon' => 'bi-chat-dots', 'text' => 'Requerimentos e suporte sem sair de casa'],
];

// Login simulado: a sessão só guarda a matrícula do aluno encontrado em STUDENTS.
function startSession(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

// Caminho relativo da página atual até a pasta web (ex.: "../../" para pages/auth/login.php).
function pathToWebRoot(): string
{
    $pageFromWebRoot = substr(currentPagePath(), strlen(realpath(WEB_ROOT)) + 1);

    return str_repeat('../', substr_count(str_replace('\\', '/', $pageFromWebRoot), '/'));
}

function redirectTo(string $path): never
{
    header('Location: ' . pathToWebRoot() . $path);
    exit;
}

// Campo do POST como texto; valores enviados como array (ex.: registration[]=) viram vazio.
function postedText(string $field): string
{
    $value = $_POST[$field] ?? '';
    return is_string($value) ? $value : '';
}

function normalizeRegistration(string $registration): string
{
    return preg_replace('/\D/', '', $registration);
}

function validateLogin(string $registration, string $password): array
{
    $errors = [];

    if ($registration === '') {
        $errors['registration'] = LOGIN_MESSAGES['registration_required'];
    } elseif (!preg_match('/^' . REGISTRATION_PATTERN . '$/', $registration)) {
        $errors['registration'] = LOGIN_MESSAGES['registration_invalid'];
    }

    if ($password === '') {
        $errors['password'] = LOGIN_MESSAGES['password_required'];
    }

    return $errors;
}

function login(string $registration, string $password): array
{
    $errors = validateLogin($registration, $password);
    if ($errors) {
        return $errors;
    }

    $student = STUDENTS[$registration] ?? null;
    if ($student === null || $student['password'] !== $password) {
        return ['credentials' => LOGIN_MESSAGES['wrong_credentials']];
    }

    startSession();
    $_SESSION['registration'] = $registration;

    return [];
}

function logout(): void
{
    startSession();
    session_destroy();
}

function loggedStudent(): ?array
{
    startSession();

    return STUDENTS[$_SESSION['registration'] ?? ''] ?? null;
}

function requireLogin(): void
{
    if (loggedStudent() === null) {
        redirectTo(LOGIN_PATH);
    }
}

function currentStudent(): array
{
    requireLogin();

    return loggedStudent();
}

// Chave do localStorage separada por aluno, para um não ver o que o outro salvou no mesmo navegador.
function studentStorageKey(string $name): string
{
    return 'alunonet.' . $name . '.' . currentStudent()['registration'];
}
