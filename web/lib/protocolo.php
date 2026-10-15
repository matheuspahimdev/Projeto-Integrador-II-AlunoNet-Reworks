<?php
require_once __DIR__ . '/autenticacao.php';

const REQUEST_STATUSES = [
    'concluido' => ['label' => 'Concluído', 'class' => 'text-bg-success'],
    'analise' => ['label' => 'Em análise', 'class' => 'text-bg-warning'],
    'indeferido' => ['label' => 'Indeferido', 'class' => 'text-bg-danger'],
];

const REQUEST_STATUS_DONE = 'concluido';

const STUDENT_REQUESTS = [
    '274769' => [
        ['protocol' => '#REQ-2026-9012', 'date' => '2026-08-12', 'type' => 'Declaração de Matrícula', 'status' => 'concluido'],
        ['protocol' => '#REQ-2026-8834', 'date' => '2026-08-05', 'type' => 'Passe Escolar AVOA', 'status' => 'analise'],
    ],
    '281450' => [
        ['protocol' => '#REQ-2026-9230', 'date' => '2026-10-08', 'type' => 'Revisão de Prova', 'status' => 'analise'],
        ['protocol' => '#REQ-2026-9105', 'date' => '2026-09-02', 'type' => 'Histórico Escolar', 'status' => 'concluido'],
    ],
    '268112' => [
        ['protocol' => '#REQ-2026-9301', 'date' => '2026-10-11', 'type' => 'Negociação de Débitos', 'status' => 'analise'],
        ['protocol' => '#REQ-2026-9188', 'date' => '2026-09-25', 'type' => 'Declaração de Estágio', 'status' => 'concluido'],
        ['protocol' => '#REQ-2026-8710', 'date' => '2026-07-28', 'type' => 'Trancamento de Disciplina', 'status' => 'indeferido'],
    ],
];

const QUICK_REQUESTS = [
    ['icon' => 'bi-file-earmark-text', 'title' => 'Declaração de Matrícula', 'description' => 'Emita um comprovante oficial de que você está regularmente matriculado no semestre atual.', 'attachment' => false],
    ['icon' => 'bi-book', 'title' => 'Histórico Escolar', 'description' => 'Solicite a 1ª via gratuita (por semestre) com suas notas e disciplinas concluídas.', 'attachment' => false],
    ['icon' => 'bi-activity', 'title' => 'Atestado Médico', 'description' => 'Envie um atestado para justificar faltas por motivos de saúde.', 'attachment' => true],
    ['icon' => 'bi-briefcase', 'title' => 'Passe Escolar AVOA', 'description' => 'Solicitação para o passe escolar de uso semestral.', 'attachment' => false],
];

const OTHER_REQUESTS = [
    'Documentos' => [
        'Declaração de Conclusão de Curso',
        'Declaração de Carga Horária',
        'Ementário das Disciplinas',
        '2ª Via da Carteirinha',
    ],
    'Vida acadêmica' => [
        'Aproveitamento de Estudos',
        'Dispensa de Disciplina',
        'Revisão de Nota',
        'Segunda Chamada de Prova',
        'Transferência de Turno',
        'Trancamento de Matrícula',
        'Cancelamento de Matrícula',
    ],
    'Estágio e formatura' => [
        'Declaração de Estágio',
        'Colação de Grau',
    ],
];

function requestStatus(array $request): array
{
    return REQUEST_STATUSES[$request['status']] ?? ['label' => $request['status'], 'class' => 'text-bg-secondary'];
}

function studentRequests(): array
{
    return STUDENT_REQUESTS[currentStudent()['registration']] ?? [];
}
