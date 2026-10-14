<?php
require_once __DIR__ . '/tempo.php';

const NOTIFICATION_PREFERENCES = [
    ['key' => 'avisosEmail', 'label' => 'Receber avisos importantes por e-mail', 'checked' => true],
    ['key' => 'lembreteProva', 'label' => 'Lembretes de provas e apresentações', 'checked' => true],
    ['key' => 'lembreteBoleto', 'label' => 'Lembrete de vencimento de boleto', 'checked' => true],
    ['key' => 'avisoBiblioteca', 'label' => 'Avisos de devolução de livros', 'checked' => true],
];

const PASSWORD_RULES = [
    'length' => 'Pelo menos 8 caracteres',
    'lower' => 'Uma letra minúscula',
    'upper' => 'Uma letra maiúscula',
    'number' => 'Um número',
    'special' => 'Um símbolo (ex.: ! @ #)',
];

function lastPasswordChange(): string
{
    return today()->modify('-97 days')->format('d/m/Y');
}
