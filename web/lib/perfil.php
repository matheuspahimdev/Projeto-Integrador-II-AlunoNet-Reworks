<?php

const NOTIFICATION_PREFERENCES = [
    ['key' => 'noticesByEmail', 'label' => 'Receber avisos importantes por e-mail', 'checked' => true],
    ['key' => 'examReminders', 'label' => 'Lembretes de provas e apresentações', 'checked' => true],
    ['key' => 'invoiceReminders', 'label' => 'Lembrete de vencimento de boleto', 'checked' => true],
    ['key' => 'libraryReminders', 'label' => 'Avisos de devolução de livros', 'checked' => true],
];

const LAST_PASSWORD_CHANGE = '2026-07-09';

const PASSWORD_RULES = [
    'length' => 'Pelo menos 8 caracteres',
    'lower' => 'Uma letra minúscula',
    'upper' => 'Uma letra maiúscula',
    'number' => 'Um número',
    'special' => 'Um símbolo (ex.: ! @ #)',
];
