<?php
require_once __DIR__ . '/academico.php';

const EVALUATION_DEADLINE = '2026-10-30';

const RATING_SCALE = [
    1 => 'Muito ruim',
    2 => 'Ruim',
    3 => 'Regular',
    4 => 'Bom',
    5 => 'Excelente',
];

const EVALUATION_SECTIONS = [
    ['name' => 'infrastructure', 'icon' => 'bi-house', 'title' => '1. Infraestrutura e Serviços', 'question' => 'Como avalia as condições das salas de aula, laboratórios e biblioteca?'],
    ['name' => 'service', 'icon' => 'bi-plus-circle', 'title' => '2. Atendimento Institucional', 'question' => 'Como avalia a agilidade e eficiência do atendimento da Secretaria?'],
];

// As disciplinas avaliadas são as que o aluno logado está cursando.
function evaluatedDisciplines(): array
{
    return array_map(
        static fn (string $key, array $discipline): array => ['id' => $key, 'label' => $discipline['name'] . ' — ' . $discipline['teacher']],
        array_keys(studentDisciplines()),
        studentDisciplines(),
    );
}
