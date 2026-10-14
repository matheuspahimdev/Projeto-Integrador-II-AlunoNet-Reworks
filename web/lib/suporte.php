<?php
require_once __DIR__ . '/tempo.php';

const SUPPORT_DEPARTMENTS = [
    'secretaria' => ['label' => 'Secretaria', 'icon' => 'bi-building', 'desc' => 'Documentos, matrícula, notas e dados cadastrais.', 'prazo' => 'até 2 dias úteis'],
    'ti' => ['label' => 'TI', 'icon' => 'bi-pc-display', 'desc' => 'Acesso ao portal, senhas, Wi-Fi e laboratórios.', 'prazo' => 'até 1 dia útil'],
    'financeiro' => ['label' => 'Financeiro', 'icon' => 'bi-cash-coin', 'desc' => 'Boletos, pagamentos, negociação e informe de rendimentos.', 'prazo' => 'até 2 dias úteis'],
    'coordenacao' => ['label' => 'Coordenação', 'icon' => 'bi-diagram-3', 'desc' => 'Grade curricular, estágio, TCC e atividades complementares.', 'prazo' => 'até 3 dias úteis'],
    'biblioteca' => ['label' => 'Biblioteca', 'icon' => 'bi-book', 'desc' => 'Empréstimos, acervo e sugestões de aquisição.', 'prazo' => 'até 2 dias úteis'],
];

const SUPPORT_REQUEST_TYPES = [
    'secretaria' => [
        'Correção de dados cadastrais',
        'Lançamento ou correção de nota/falta',
        'Justificativa de falta',
        'Dúvida sobre matrícula',
        'Segunda via de documento',
    ],
    'ti' => [
        'Esqueci minha senha do portal',
        'Acesso bloqueado ao portal ou Moodle',
        'Problema no Wi-Fi do campus',
        'Problema em computador de laboratório',
        'E-mail institucional',
    ],
    'financeiro' => [
        'Segunda via de boleto',
        'Boleto com valor incorreto',
        'Pagamento não identificado',
        'Negociação de débitos',
        'Informe de rendimentos (IR)',
    ],
    'coordenacao' => [
        'Aproveitamento de estudos',
        'Orientação sobre grade curricular',
        'Atividades complementares',
        'Dúvida sobre estágio ou TCC',
        'Reclamação sobre disciplina',
    ],
    'biblioteca' => [
        'Pendência ou multa de empréstimo',
        'Livro não encontrado no acervo',
        'Sugestão de aquisição de livro',
        'Problema com agendamento de empréstimo',
    ],
];

function supportDepartmentBadges(): array
{
    return array_map(
        static fn (array $department): array => ['label' => $department['label'], 'icon' => $department['icon']],
        SUPPORT_DEPARTMENTS,
    );
}

function ticketEntry(int $daysFromToday, string $time, string $author, string $message): array
{
    return ['em' => dateTimeFromToday($daysFromToday, $time), 'autor' => $author, 'texto' => $message];
}

function supportTickets(): array
{
    return [
        [
            'id' => 'CH-2026-0187', 'departamento' => 'ti', 'tipo' => 'Acesso bloqueado ao portal ou Moodle',
            'assunto' => 'Acesso bloqueado ao portal',
            'descricao' => 'Depois de errar a senha algumas vezes, o portal passou a informar que meu acesso está bloqueado. Preciso entrar para consultar notas e materiais.',
            'anexo' => null, 'contato' => 'Portal', 'status' => 'andamento',
            'abertoEm' => dateTimeFromToday(-2, '09:12'), 'atualizadoEm' => dateTimeFromToday(-1, '14:30'),
            'historico' => [
                ticketEntry(-2, '09:12', 'Você', 'Chamado aberto.'),
                ticketEntry(-1, '14:30', 'TI', 'Chamado em análise. Estamos verificando o bloqueio na sua conta.'),
            ],
        ],
        [
            'id' => 'CH-2026-0179', 'departamento' => 'financeiro', 'tipo' => 'Boleto com valor incorreto',
            'assunto' => 'Boleto de setembro com valor incorreto',
            'descricao' => 'O boleto de setembro veio com um valor diferente do contratado. Gostaria de conferir se houve algum lançamento indevido.',
            'anexo' => 'boleto-setembro.pdf', 'contato' => 'E-mail', 'status' => 'aguardando',
            'abertoEm' => dateTimeFromToday(-4, '16:45'), 'atualizadoEm' => dateTimeFromToday(-1, '10:05'),
            'historico' => [
                ticketEntry(-4, '16:45', 'Você', 'Chamado aberto.'),
                ticketEntry(-3, '11:20', 'Financeiro', 'Chamado em análise pelo setor financeiro.'),
                ticketEntry(-1, '10:05', 'Financeiro', 'Para continuar, envie o comprovante do último pagamento realizado.'),
            ],
        ],
        [
            'id' => 'CH-2026-0162', 'departamento' => 'secretaria', 'tipo' => 'Correção de dados cadastrais',
            'assunto' => 'Correção de telefone e endereço',
            'descricao' => 'Meu telefone e endereço estão desatualizados no cadastro. Solicito a correção dos dados.',
            'anexo' => null, 'contato' => 'Portal', 'status' => 'resolvido',
            'abertoEm' => dateTimeFromToday(-12, '08:30'), 'atualizadoEm' => dateTimeFromToday(-9, '15:40'),
            'historico' => [
                ticketEntry(-12, '08:30', 'Você', 'Chamado aberto.'),
                ticketEntry(-11, '10:00', 'Secretaria', 'Solicitação recebida e em atendimento.'),
                ticketEntry(-9, '15:40', 'Secretaria', 'Dados atualizados no sistema. Confira em Dados Cadastrais.'),
            ],
        ],
        [
            'id' => 'CH-2026-0150', 'departamento' => 'biblioteca', 'tipo' => 'Livro não encontrado no acervo',
            'assunto' => 'Livro de Redes não localizado',
            'descricao' => 'Não encontrei na estante o exemplar que consta como disponível no acervo.',
            'anexo' => null, 'contato' => 'Portal', 'status' => 'cancelado',
            'abertoEm' => dateTimeFromToday(-20, '13:15'), 'atualizadoEm' => dateTimeFromToday(-20, '13:40'),
            'historico' => [
                ticketEntry(-20, '13:15', 'Você', 'Chamado aberto.'),
                ticketEntry(-20, '13:40', 'Você', 'Chamado cancelado pelo solicitante.'),
            ],
        ],
    ];
}