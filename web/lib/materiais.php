<?php
require_once __DIR__ . '/academico.php';

const REPOSITORY_OWNER_STUDENT = 'Você';

// Pastas de disciplina usam o professor da disciplina como dono; as demais informam 'owner'.
// Arquivos herdam o dono da pasta em que estão.
const REPOSITORY_RECORDS = [
    '274769' => [
        'folders' => [
            ['id' => 1, 'parent' => null, 'name' => 'Projeto Integrador II', 'modified' => '2026-10-08', 'discipline' => 'projetoIntegrador'],
            ['id' => 2, 'parent' => null, 'name' => 'Direito Aplicado', 'modified' => '2026-10-05', 'discipline' => 'direitoInovacao'],
            ['id' => 3, 'parent' => null, 'name' => 'Banco de Dados', 'modified' => '2026-10-09', 'owner' => 'Prof. Nome do Professor 3'],
            ['id' => 4, 'parent' => null, 'name' => 'Programação Web', 'modified' => '2026-09-28', 'owner' => 'Prof. Nome do Professor 4'],
            ['id' => 5, 'parent' => null, 'name' => 'Documentos Pessoais', 'modified' => '2026-10-02', 'owner' => REPOSITORY_OWNER_STUDENT],
            ['id' => 6, 'parent' => 1, 'name' => 'Aulas', 'modified' => '2026-10-08'],
            ['id' => 7, 'parent' => 1, 'name' => 'Entregas', 'modified' => '2026-10-06', 'owner' => REPOSITORY_OWNER_STUDENT],
            ['id' => 8, 'parent' => 3, 'name' => 'Slides', 'modified' => '2026-10-09'],
            ['id' => 9, 'parent' => 3, 'name' => 'Listas de Exercícios', 'modified' => '2026-10-01'],
        ],
        'files' => [
            ['id' => 10, 'parent' => 1, 'name' => 'Plano de Ensino.pdf', 'size_kb' => 320, 'modified' => '2026-08-03', 'starred' => true],
            ['id' => 11, 'parent' => 1, 'name' => 'Cronograma do Projeto.xlsx', 'size_kb' => 86, 'modified' => '2026-09-14'],
            ['id' => 12, 'parent' => 1, 'name' => 'Modelo de Relatório.docx', 'size_kb' => 54, 'modified' => '2026-09-20'],
            ['id' => 13, 'parent' => 6, 'name' => 'Aula 01 - Introdução.pdf', 'size_kb' => 1228, 'modified' => '2026-08-10'],
            ['id' => 14, 'parent' => 6, 'name' => 'Aula 02 - Levantamento de Requisitos.pptx', 'size_kb' => 3482, 'modified' => '2026-09-22'],
            ['id' => 15, 'parent' => 6, 'name' => 'Gravação Aula 03.mp4', 'size_kb' => 151552, 'modified' => '2026-10-08'],
            ['id' => 16, 'parent' => 7, 'name' => 'Entrega 1 - Documento de Visão.pdf', 'size_kb' => 540, 'modified' => '2026-09-30'],
            ['id' => 17, 'parent' => 7, 'name' => 'Diagrama de Casos de Uso.png', 'size_kb' => 210, 'modified' => '2026-10-06'],
            ['id' => 18, 'parent' => 2, 'name' => 'Código de Defesa do Consumidor.pdf', 'size_kb' => 1843, 'modified' => '2026-08-12'],
            ['id' => 19, 'parent' => 2, 'name' => 'Resumo Contratos.docx', 'size_kb' => 72, 'modified' => '2026-10-05'],
            ['id' => 20, 'parent' => 3, 'name' => 'Modelo Entidade-Relacionamento.png', 'size_kb' => 480, 'modified' => '2026-09-18'],
            ['id' => 21, 'parent' => 3, 'name' => 'Script Banco Escola.sql', 'size_kb' => 12, 'modified' => '2026-10-09', 'starred' => true],
            ['id' => 22, 'parent' => 8, 'name' => 'Aula 01 - Modelagem.pptx', 'size_kb' => 2970, 'modified' => '2026-08-17'],
            ['id' => 23, 'parent' => 8, 'name' => 'Aula 02 - SQL Básico.pptx', 'size_kb' => 3174, 'modified' => '2026-09-07'],
            ['id' => 24, 'parent' => 9, 'name' => 'Lista 01.pdf', 'size_kb' => 190, 'modified' => '2026-09-10'],
            ['id' => 25, 'parent' => 9, 'name' => 'Lista 02.pdf', 'size_kb' => 205, 'modified' => '2026-10-01'],
            ['id' => 26, 'parent' => 9, 'name' => 'Gabarito Lista 01.pdf', 'size_kb' => 160, 'modified' => '2026-09-17'],
            ['id' => 27, 'parent' => 4, 'name' => 'Material Bootstrap.zip', 'size_kb' => 5734, 'modified' => '2026-09-28'],
            ['id' => 28, 'parent' => 4, 'name' => 'Referências de JavaScript.pdf', 'size_kb' => 940, 'modified' => '2026-09-15'],
            ['id' => 29, 'parent' => 5, 'name' => 'Declaração de Matrícula.pdf', 'size_kb' => 120, 'modified' => '2026-10-02', 'starred' => true],
            ['id' => 30, 'parent' => 5, 'name' => 'Histórico Escolar.pdf', 'size_kb' => 180, 'modified' => '2026-09-12'],
            ['id' => 31, 'parent' => 5, 'name' => 'Foto 3x4.jpg', 'size_kb' => 95, 'modified' => '2026-08-01'],
        ],
    ],
    '281450' => [
        'folders' => [
            ['id' => 1, 'parent' => null, 'name' => 'Programação para Web', 'modified' => '2026-10-07', 'discipline' => 'programacaoWeb'],
            ['id' => 2, 'parent' => null, 'name' => 'Banco de Dados II', 'modified' => '2026-10-09', 'discipline' => 'bancoDados'],
            ['id' => 3, 'parent' => null, 'name' => 'Projeto Integrador IV', 'modified' => '2026-10-10', 'discipline' => 'projetoIntegrador'],
            ['id' => 4, 'parent' => null, 'name' => 'Documentos Pessoais', 'modified' => '2026-09-25', 'owner' => REPOSITORY_OWNER_STUDENT],
            ['id' => 5, 'parent' => 3, 'name' => 'Entregas', 'modified' => '2026-10-10', 'owner' => REPOSITORY_OWNER_STUDENT],
        ],
        'files' => [
            ['id' => 10, 'parent' => 1, 'name' => 'Plano de Ensino.pdf', 'size_kb' => 298, 'modified' => '2026-08-03', 'starred' => true],
            ['id' => 11, 'parent' => 1, 'name' => 'Aula 05 - APIs REST.pptx', 'size_kb' => 2860, 'modified' => '2026-09-28'],
            ['id' => 12, 'parent' => 1, 'name' => 'Exemplo Fetch API.zip', 'size_kb' => 1450, 'modified' => '2026-10-07'],
            ['id' => 13, 'parent' => 2, 'name' => 'Procedures e Triggers.pdf', 'size_kb' => 870, 'modified' => '2026-09-21'],
            ['id' => 14, 'parent' => 2, 'name' => 'Lista 03 - Consultas Avançadas.pdf', 'size_kb' => 210, 'modified' => '2026-10-09', 'starred' => true],
            ['id' => 15, 'parent' => 3, 'name' => 'Cronograma do Projeto.xlsx', 'size_kb' => 92, 'modified' => '2026-08-12'],
            ['id' => 16, 'parent' => 5, 'name' => 'Entrega 2 - Protótipo Navegável.pdf', 'size_kb' => 3120, 'modified' => '2026-10-10'],
            ['id' => 17, 'parent' => 4, 'name' => 'Histórico Escolar.pdf', 'size_kb' => 176, 'modified' => '2026-09-25'],
        ],
    ],
    '268112' => [
        'folders' => [
            ['id' => 1, 'parent' => null, 'name' => 'Administração Financeira', 'modified' => '2026-10-05', 'discipline' => 'gestaoFinanceira'],
            ['id' => 2, 'parent' => null, 'name' => 'Marketing Estratégico', 'modified' => '2026-10-08', 'discipline' => 'marketing'],
            ['id' => 3, 'parent' => null, 'name' => 'Logística Empresarial', 'modified' => '2026-09-30', 'discipline' => 'logistica'],
            ['id' => 4, 'parent' => null, 'name' => 'Estágio Supervisionado', 'modified' => '2026-10-01', 'owner' => REPOSITORY_OWNER_STUDENT],
        ],
        'files' => [
            ['id' => 10, 'parent' => 1, 'name' => 'Fluxo de Caixa - Planilha Modelo.xlsx', 'size_kb' => 64, 'modified' => '2026-09-14', 'starred' => true],
            ['id' => 11, 'parent' => 1, 'name' => 'Análise de Investimentos.pdf', 'size_kb' => 1320, 'modified' => '2026-10-05'],
            ['id' => 12, 'parent' => 2, 'name' => 'Estudo de Caso - Lançamento de Produto.pdf', 'size_kb' => 980, 'modified' => '2026-10-08'],
            ['id' => 13, 'parent' => 2, 'name' => 'Matriz SWOT.docx', 'size_kb' => 48, 'modified' => '2026-09-22'],
            ['id' => 14, 'parent' => 3, 'name' => 'Gestão de Estoques.pptx', 'size_kb' => 2540, 'modified' => '2026-09-30'],
            ['id' => 15, 'parent' => 4, 'name' => 'Termo de Compromisso de Estágio.pdf', 'size_kb' => 210, 'modified' => '2026-08-20', 'starred' => true],
            ['id' => 16, 'parent' => 4, 'name' => 'Relatório Parcial de Estágio.docx', 'size_kb' => 156, 'modified' => '2026-10-01'],
        ],
    ],
];

function repositoryRecord(): array
{
    return REPOSITORY_RECORDS[currentStudent()['registration']] ?? ['folders' => [], 'files' => []];
}

// Dono da pasta: o informado, o professor da disciplina ou, para subpastas, o dono da pasta-mãe.
function folderOwners(array $folders): array
{
    $owners = [];
    foreach ($folders as $folder) {
        $owners[$folder['id']] = $folder['owner']
            ?? (isset($folder['discipline']) ? studentDisciplines()[$folder['discipline']]['teacher'] : $owners[$folder['parent']]);
    }

    return $owners;
}

function repositoryItems(): array
{
    $record = repositoryRecord();
    $owners = folderOwners($record['folders']);

    $folders = array_map(static fn (array $folder): array => [
        'id' => $folder['id'], 'parent' => $folder['parent'], 'type' => 'folder', 'name' => $folder['name'], 'ext' => '',
        'size' => 0, 'modified' => $folder['modified'], 'owner' => $owners[$folder['id']], 'starred' => false,
    ], $record['folders']);

    $files = array_map(static fn (array $file): array => [
        'id' => $file['id'], 'parent' => $file['parent'], 'type' => 'file', 'name' => $file['name'],
        'ext' => strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)), 'size' => $file['size_kb'] * 1024,
        'modified' => $file['modified'], 'owner' => $owners[$file['parent']], 'starred' => $file['starred'] ?? false,
    ], $record['files']);

    return array_merge($folders, $files);
}
