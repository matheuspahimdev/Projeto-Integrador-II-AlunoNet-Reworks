<?php
require_once __DIR__ . '/autenticacao.php';

const TICKET_RULES = [
    'subject_min_length' => 5,
    'description_min_length' => 10,
    'other_description_min_length' => 20,
    'description_max_length' => 1500,
    'attachment_max_mb' => 5,
];

const TICKET_STATUS_OPEN = 'aberto';

const SUPPORT_DEPARTMENTS = [
    'secretaria' => ['label' => 'Secretaria', 'icon' => 'bi-building', 'description' => 'Documentos, matrícula, notas e dados cadastrais.', 'response_time' => 'até 2 dias úteis'],
    'ti' => ['label' => 'TI', 'icon' => 'bi-pc-display', 'description' => 'Acesso ao portal, senhas, Wi-Fi e laboratórios.', 'response_time' => 'até 1 dia útil'],
    'financeiro' => ['label' => 'Financeiro', 'icon' => 'bi-cash-coin', 'description' => 'Boletos, pagamentos, negociação e informe de rendimentos.', 'response_time' => 'até 2 dias úteis'],
    'coordenacao' => ['label' => 'Coordenação', 'icon' => 'bi-diagram-3', 'description' => 'Grade curricular, estágio, TCC e atividades complementares.', 'response_time' => 'até 3 dias úteis'],
    'biblioteca' => ['label' => 'Biblioteca', 'icon' => 'bi-book', 'description' => 'Empréstimos, acervo e sugestões de aquisição.', 'response_time' => 'até 2 dias úteis'],
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

const SUPPORT_TICKETS = [
    '274769' => [
        [
            'id' => 'CH-2026-0187', 'department' => 'ti', 'type' => 'Acesso bloqueado ao portal ou Moodle',
            'subject' => 'Acesso bloqueado ao portal',
            'description' => 'Depois de errar a senha algumas vezes, o portal passou a informar que meu acesso está bloqueado. Preciso entrar para consultar notas e materiais.',
            'attachment' => null, 'contact' => 'Portal', 'status' => 'andamento',
            'opened_at' => '2026-10-12T09:12', 'updated_at' => '2026-10-13T14:30',
            'history' => [
                ['at' => '2026-10-12T09:12', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-10-13T14:30', 'author' => 'TI', 'text' => 'Chamado em análise. Estamos verificando o bloqueio na sua conta.'],
            ],
        ],
        [
            'id' => 'CH-2026-0179', 'department' => 'financeiro', 'type' => 'Boleto com valor incorreto',
            'subject' => 'Boleto de setembro com valor incorreto',
            'description' => 'O boleto de setembro veio com um valor diferente do contratado. Gostaria de conferir se houve algum lançamento indevido.',
            'attachment' => 'boleto-setembro.pdf', 'contact' => 'E-mail', 'status' => 'aguardando',
            'opened_at' => '2026-10-10T16:45', 'updated_at' => '2026-10-13T10:05',
            'history' => [
                ['at' => '2026-10-10T16:45', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-10-11T11:20', 'author' => 'Financeiro', 'text' => 'Chamado em análise pelo setor financeiro.'],
                ['at' => '2026-10-13T10:05', 'author' => 'Financeiro', 'text' => 'Para continuar, envie o comprovante do último pagamento realizado.'],
            ],
        ],
        [
            'id' => 'CH-2026-0162', 'department' => 'secretaria', 'type' => 'Correção de dados cadastrais',
            'subject' => 'Correção de telefone e endereço',
            'description' => 'Meu telefone e endereço estão desatualizados no cadastro. Solicito a correção dos dados.',
            'attachment' => null, 'contact' => 'Portal', 'status' => 'resolvido',
            'opened_at' => '2026-10-02T08:30', 'updated_at' => '2026-10-05T15:40',
            'history' => [
                ['at' => '2026-10-02T08:30', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-10-03T10:00', 'author' => 'Secretaria', 'text' => 'Solicitação recebida e em atendimento.'],
                ['at' => '2026-10-05T15:40', 'author' => 'Secretaria', 'text' => 'Dados atualizados no sistema. Confira em Dados Cadastrais.'],
            ],
        ],
        [
            'id' => 'CH-2026-0150', 'department' => 'biblioteca', 'type' => 'Livro não encontrado no acervo',
            'subject' => 'Livro de Redes não localizado',
            'description' => 'Não encontrei na estante o exemplar que consta como disponível no acervo.',
            'attachment' => null, 'contact' => 'Portal', 'status' => 'cancelado',
            'opened_at' => '2026-09-24T13:15', 'updated_at' => '2026-09-24T13:40',
            'history' => [
                ['at' => '2026-09-24T13:15', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-09-24T13:40', 'author' => 'Você', 'text' => 'Chamado cancelado pelo solicitante.'],
            ],
        ],
    ],
    '281450' => [
        [
            'id' => 'CH-2026-0191', 'department' => 'coordenacao', 'type' => 'Revisão de nota',
            'subject' => 'Revisão da 1ª avaliação de Engenharia de Software',
            'description' => 'Gostaria de solicitar a revisão da correção da minha 1ª avaliação, pois acredito que uma questão foi considerada errada indevidamente.',
            'attachment' => 'avaliacao-eng-software.pdf', 'contact' => 'Portal', 'status' => 'andamento',
            'opened_at' => '2026-10-11T10:20', 'updated_at' => '2026-10-13T09:15',
            'history' => [
                ['at' => '2026-10-11T10:20', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-10-13T09:15', 'author' => 'Coordenação', 'text' => 'Solicitação encaminhada ao professor responsável pela disciplina.'],
            ],
        ],
        [
            'id' => 'CH-2026-0171', 'department' => 'ti', 'type' => 'Problema no Wi-Fi do campus',
            'subject' => 'Wi-Fi instável no Bloco 3',
            'description' => 'A rede Wi-Fi do Bloco 3 cai com frequência durante as aulas práticas no laboratório.',
            'attachment' => null, 'contact' => 'Portal', 'status' => 'resolvido',
            'opened_at' => '2026-10-06T08:05', 'updated_at' => '2026-10-08T17:30',
            'history' => [
                ['at' => '2026-10-06T08:05', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-10-07T11:00', 'author' => 'TI', 'text' => 'Equipe técnica verificando os pontos de acesso do bloco.'],
                ['at' => '2026-10-08T17:30', 'author' => 'TI', 'text' => 'Ponto de acesso substituído. A conexão deve estar estável.'],
            ],
        ],
    ],
    '268112' => [
        [
            'id' => 'CH-2026-0189', 'department' => 'financeiro', 'type' => 'Negociação de débitos',
            'subject' => 'Parcelamento das mensalidades em atraso',
            'description' => 'Estou com duas mensalidades em atraso e gostaria de saber as condições para parcelar o valor.',
            'attachment' => null, 'contact' => 'Telefone', 'status' => 'aguardando',
            'opened_at' => '2026-10-12T19:40', 'updated_at' => '2026-10-13T16:10',
            'history' => [
                ['at' => '2026-10-12T19:40', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-10-13T16:10', 'author' => 'Financeiro', 'text' => 'Enviamos as opções de parcelamento por e-mail. Confirme a opção escolhida para gerarmos os boletos.'],
            ],
        ],
        [
            'id' => 'CH-2026-0158', 'department' => 'coordenacao', 'type' => 'Dúvida sobre estágio',
            'subject' => 'Validação das horas de estágio',
            'description' => 'Preciso saber quais documentos devo entregar para validar as horas do estágio supervisionado.',
            'attachment' => null, 'contact' => 'E-mail', 'status' => 'resolvido',
            'opened_at' => '2026-09-29T20:10', 'updated_at' => '2026-10-01T14:00',
            'history' => [
                ['at' => '2026-09-29T20:10', 'author' => 'Você', 'text' => 'Chamado aberto.'],
                ['at' => '2026-10-01T14:00', 'author' => 'Coordenação', 'text' => 'Entregue o termo de compromisso e o relatório de atividades assinados pelo supervisor.'],
            ],
        ],
    ],
];

function supportDepartmentBadges(): array
{
    return array_map(
        static fn (array $department): array => ['label' => $department['label'], 'icon' => $department['icon']],
        SUPPORT_DEPARTMENTS,
    );
}

function supportTickets(): array
{
    return SUPPORT_TICKETS[currentStudent()['registration']] ?? [];
}
