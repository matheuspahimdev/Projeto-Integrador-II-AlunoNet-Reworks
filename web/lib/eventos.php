<?php

const EVENT_CATEGORIES = [
    'prova' => ['label' => 'Prova', 'icon' => 'bi-pencil-square'],
    'apresentacao' => ['label' => 'Apresentação do Projeto Integrador', 'icon' => 'bi-easel'],
    'feriado' => ['label' => 'Feriado', 'icon' => 'bi-flag'],
    'palestra' => ['label' => 'Palestra / Evento', 'icon' => 'bi-mic'],
    'oficina' => ['label' => 'Oficina / Minicurso', 'icon' => 'bi-tools'],
    'prazo' => ['label' => 'Prazo / Marco acadêmico', 'icon' => 'bi-hourglass-split'],
];

function calendarEvent(string $date, string $category, string $title, ?string $time = null, ?string $place = null, ?string $description = null): array
{
    return ['data' => $date, 'categoria' => $category, 'titulo' => $title, 'hora' => $time, 'local' => $place, 'descricao' => $description];
}

function holidays(): array
{
    return [
        calendarEvent('2026-01-01', 'feriado', 'Confraternização Universal'),
        calendarEvent('2026-02-16', 'feriado', 'Carnaval (ponto facultativo)'),
        calendarEvent('2026-02-17', 'feriado', 'Carnaval (ponto facultativo)'),
        calendarEvent('2026-04-03', 'feriado', 'Sexta-feira Santa'),
        calendarEvent('2026-04-21', 'feriado', 'Tiradentes'),
        calendarEvent('2026-05-01', 'feriado', 'Dia do Trabalho'),
        calendarEvent('2026-06-04', 'feriado', 'Corpus Christi (ponto facultativo)'),
        calendarEvent('2026-09-07', 'feriado', 'Independência do Brasil'),
        calendarEvent('2026-10-12', 'feriado', 'Nossa Senhora Aparecida'),
        calendarEvent('2026-11-02', 'feriado', 'Finados', null, null, 'Não haverá aulas. As atividades retornam na terça-feira, 03/11.'),
        calendarEvent('2026-11-15', 'feriado', 'Proclamação da República'),
        calendarEvent('2026-11-20', 'feriado', 'Consciência Negra'),
        calendarEvent('2026-12-25', 'feriado', 'Natal'),
    ];
}

function examEvents(): array
{
    return [
        calendarEvent('2026-09-22', 'prova', 'Prova — Programação Web', '19:00', 'Sala 204 — Bloco 1'),
        calendarEvent('2026-09-24', 'prova', 'Prova — Direito Aplicado', '19:00', 'Sala 305 — Bloco 1'),
        calendarEvent('2026-10-20', 'prova', 'Prova — Projeto Integrador II', '19:00', 'Sala 712 — Bloco 2', 'Sala alterada conforme aviso da coordenação. Leve documento com foto e chegue com 15 minutos de antecedência.'),
        calendarEvent('2026-10-22', 'prova', 'Prova — Banco de Dados', '19:00', 'Sala 305 — Bloco 1'),
        calendarEvent('2026-10-29', 'prova', 'Prova — Programação Web', '19:00', 'Sala 204 — Bloco 1'),
        calendarEvent('2026-12-08', 'prova', 'Prova substitutiva', '19:00', 'Bloco 1', 'Para alunos que não realizaram alguma prova do semestre.'),
        calendarEvent('2026-12-10', 'prova', 'Exame final', '19:00', 'Bloco 1'),
    ];
}

function integratorProjectPresentations(): array
{
    $description = 'Apresentação do projeto para a banca avaliadora, com cerca de 15 minutos por grupo.';

    return [
        calendarEvent('2026-11-24', 'apresentacao', 'Apresentação do Projeto Integrador II — Turma A', '19:00', 'Auditório Central', $description),
        calendarEvent('2026-11-26', 'apresentacao', 'Apresentação do Projeto Integrador II — Turma B', '19:00', 'Auditório Central', $description),
    ];
}

function lectureEvents(): array
{
    return [
        calendarEvent('2026-09-17', 'palestra', 'Palestra: Direito Digital e LGPD', '19:30', 'Auditório Central'),
        calendarEvent('2026-10-26', 'palestra', 'Abertura da Semana de Tecnologia', '19:30', 'Auditório Central', 'Palestra de abertura sobre inteligência artificial aplicada ao desenvolvimento de software.'),
        calendarEvent('2026-10-28', 'palestra', 'Maratona de Programação', '14:00', 'Laboratório de Informática 2', 'Competição em equipes, parte da Semana de Tecnologia.'),
        calendarEvent('2026-11-12', 'palestra', 'Palestra: Carreira em Tecnologia', '19:30', 'Auditório Central', 'Promovida pelo núcleo de carreiras.'),
    ];
}

function workshopEvents(): array
{
    return [
        calendarEvent('2026-10-27', 'oficina', 'Minicurso de Git e GitHub', '19:00', 'Laboratório de Informática 2', 'Vagas limitadas. Inscrição na secretaria.'),
        calendarEvent('2026-11-05', 'oficina', 'Oficina de Currículo e LinkedIn', '18:30', 'Sala de Reuniões — Bloco 2'),
    ];
}

function academicDeadlines(): array
{
    return [
        calendarEvent('2026-08-03', 'prazo', 'Início do semestre letivo'),
        calendarEvent('2026-08-10', 'prazo', 'Vencimento da mensalidade'),
        calendarEvent('2026-09-10', 'prazo', 'Vencimento da mensalidade'),
        calendarEvent('2026-10-10', 'prazo', 'Vencimento da mensalidade'),
        calendarEvent('2026-10-30', 'prazo', 'Prazo da Avaliação Institucional (CPA)', null, 'Portal do aluno', 'Responda ao questionário até esta data.'),
        calendarEvent('2026-11-10', 'prazo', 'Vencimento da mensalidade'),
        calendarEvent('2026-11-17', 'prazo', 'Entrega do relatório final — Projeto Integrador II', null, 'Portal do aluno'),
        calendarEvent('2026-12-10', 'prazo', 'Vencimento da mensalidade'),
        calendarEvent('2026-12-11', 'prazo', 'Último dia para registrar atividades complementares', null, 'Portal do aluno'),
        calendarEvent('2026-12-18', 'prazo', 'Encerramento do semestre letivo'),
    ];
}

function calendarEvents(): array
{
    return array_merge(
        holidays(),
        examEvents(),
        integratorProjectPresentations(),
        lectureEvents(),
        workshopEvents(),
        academicDeadlines(),
    );
}