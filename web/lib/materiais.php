<?php

const REPOSITORY_OWNER_STUDENT = 'Você';

const REPOSITORY_TEACHERS = [
    'projetoIntegrador' => 'Prof. Nome do Professor 1',
    'direitoAplicado' => 'Prof. Nome do Professor 2',
    'bancoDados' => 'Prof. Nome do Professor 3',
    'programacaoWeb' => 'Prof. Nome do Professor 4',
];

function repositoryFolder(int $id, ?int $parent, string $name, string $modified, string $owner): array
{
    return [
        'id' => $id, 'parent' => $parent, 'type' => 'folder', 'name' => $name, 'ext' => '',
        'size' => 0, 'modified' => $modified, 'owner' => $owner, 'starred' => false,
    ];
}

function repositoryFile(int $id, ?int $parent, string $name, int $sizeInKb, string $modified, string $owner, bool $starred = false): array
{
    return [
        'id' => $id, 'parent' => $parent, 'type' => 'file', 'name' => $name,
        'ext' => strtolower(pathinfo($name, PATHINFO_EXTENSION)), 'size' => $sizeInKb * 1024,
        'modified' => $modified, 'owner' => $owner, 'starred' => $starred,
    ];
}

function repositoryFolders(): array
{
    $teachers = REPOSITORY_TEACHERS;
    $student = REPOSITORY_OWNER_STUDENT;

    return [
        repositoryFolder(1, null, 'Projeto Integrador II', '2026-10-08', $teachers['projetoIntegrador']),
        repositoryFolder(2, null, 'Direito Aplicado', '2026-10-05', $teachers['direitoAplicado']),
        repositoryFolder(3, null, 'Banco de Dados', '2026-10-09', $teachers['bancoDados']),
        repositoryFolder(4, null, 'Programação Web', '2026-09-28', $teachers['programacaoWeb']),
        repositoryFolder(5, null, 'Documentos Pessoais', '2026-10-02', $student),
        repositoryFolder(6, 1, 'Aulas', '2026-10-08', $teachers['projetoIntegrador']),
        repositoryFolder(7, 1, 'Entregas', '2026-10-06', $student),
        repositoryFolder(8, 3, 'Slides', '2026-10-09', $teachers['bancoDados']),
        repositoryFolder(9, 3, 'Listas de Exercícios', '2026-10-01', $teachers['bancoDados']),
    ];
}

function integratorProjectFiles(): array
{
    $teacher = REPOSITORY_TEACHERS['projetoIntegrador'];
    $student = REPOSITORY_OWNER_STUDENT;

    return [
        repositoryFile(10, 1, 'Plano de Ensino.pdf', 320, '2026-08-03', $teacher, true),
        repositoryFile(11, 1, 'Cronograma do Projeto.xlsx', 86, '2026-09-14', $teacher),
        repositoryFile(12, 1, 'Modelo de Relatório.docx', 54, '2026-09-20', $teacher),
        repositoryFile(13, 6, 'Aula 01 - Introdução.pdf', 1228, '2026-08-10', $teacher),
        repositoryFile(14, 6, 'Aula 02 - Levantamento de Requisitos.pptx', 3482, '2026-09-22', $teacher),
        repositoryFile(15, 6, 'Gravação Aula 03.mp4', 151552, '2026-10-08', $teacher),
        repositoryFile(16, 7, 'Entrega 1 - Documento de Visão.pdf', 540, '2026-09-30', $student),
        repositoryFile(17, 7, 'Diagrama de Casos de Uso.png', 210, '2026-10-06', $student),
    ];
}

function appliedLawFiles(): array
{
    $teacher = REPOSITORY_TEACHERS['direitoAplicado'];

    return [
        repositoryFile(18, 2, 'Código de Defesa do Consumidor.pdf', 1843, '2026-08-12', $teacher),
        repositoryFile(19, 2, 'Resumo Contratos.docx', 72, '2026-10-05', $teacher),
    ];
}

function databaseFiles(): array
{
    $teacher = REPOSITORY_TEACHERS['bancoDados'];

    return [
        repositoryFile(20, 3, 'Modelo Entidade-Relacionamento.png', 480, '2026-09-18', $teacher),
        repositoryFile(21, 3, 'Script Banco Escola.sql', 12, '2026-10-09', $teacher, true),
        repositoryFile(22, 8, 'Aula 01 - Modelagem.pptx', 2970, '2026-08-17', $teacher),
        repositoryFile(23, 8, 'Aula 02 - SQL Básico.pptx', 3174, '2026-09-07', $teacher),
        repositoryFile(24, 9, 'Lista 01.pdf', 190, '2026-09-10', $teacher),
        repositoryFile(25, 9, 'Lista 02.pdf', 205, '2026-10-01', $teacher),
        repositoryFile(26, 9, 'Gabarito Lista 01.pdf', 160, '2026-09-17', $teacher),
    ];
}

function webProgrammingFiles(): array
{
    $teacher = REPOSITORY_TEACHERS['programacaoWeb'];

    return [
        repositoryFile(27, 4, 'Material Bootstrap.zip', 5734, '2026-09-28', $teacher),
        repositoryFile(28, 4, 'Referências de JavaScript.pdf', 940, '2026-09-15', $teacher),
    ];
}

function personalDocuments(): array
{
    $student = REPOSITORY_OWNER_STUDENT;

    return [
        repositoryFile(29, 5, 'Declaração de Matrícula.pdf', 120, '2026-10-02', $student, true),
        repositoryFile(30, 5, 'Histórico Escolar.pdf', 180, '2026-09-12', $student),
        repositoryFile(31, 5, 'Foto 3x4.jpg', 95, '2026-08-01', $student),
    ];
}

function repositoryItems(): array
{
    return array_merge(
        repositoryFolders(),
        integratorProjectFiles(),
        appliedLawFiles(),
        databaseFiles(),
        webProgrammingFiles(),
        personalDocuments(),
    );
}