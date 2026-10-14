<?php

const REQUEST_STATUSES = [
    'concluido' => ['label' => 'Concluído', 'class' => 'text-bg-success'],
    'analise' => ['label' => 'Em análise', 'class' => 'text-bg-warning'],
    'indeferido' => ['label' => 'Indeferido', 'class' => 'text-bg-danger'],
];

const STUDENT_REQUESTS = [
    ['protocolo' => '#REQ-2026-9012', 'data' => '12/08/2026', 'tipo' => 'Declaração de Matrícula', 'status' => 'concluido'],
    ['protocolo' => '#REQ-2026-8834', 'data' => '05/08/2026', 'tipo' => 'Passe Escolar AVOA', 'status' => 'analise'],
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
    return REQUEST_STATUSES[$request['status']];
}