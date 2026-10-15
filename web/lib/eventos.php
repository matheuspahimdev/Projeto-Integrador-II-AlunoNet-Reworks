<?php
require_once __DIR__ . '/academico.php';
require_once __DIR__ . '/financeiro.php';
require_once __DIR__ . '/avaliacao.php';

const EVENT_CATEGORIES = [
    'prova' => ['label' => 'Prova', 'icon' => 'bi-pencil-square'],
    'apresentacao' => ['label' => 'Apresentação do Projeto Integrador', 'icon' => 'bi-easel'],
    'feriado' => ['label' => 'Feriado', 'icon' => 'bi-flag'],
    'palestra' => ['label' => 'Palestra / Evento', 'icon' => 'bi-mic'],
    'oficina' => ['label' => 'Oficina / Minicurso', 'icon' => 'bi-tools'],
    'prazo' => ['label' => 'Prazo / Marco acadêmico', 'icon' => 'bi-hourglass-split'],
];

const INTEGRATOR_PROJECT_KEY = 'projetoIntegrador';

const HOLIDAYS = [
    ['date' => '2026-01-01', 'title' => 'Confraternização Universal'],
    ['date' => '2026-02-16', 'title' => 'Carnaval (ponto facultativo)'],
    ['date' => '2026-02-17', 'title' => 'Carnaval (ponto facultativo)'],
    ['date' => '2026-04-03', 'title' => 'Sexta-feira Santa'],
    ['date' => '2026-04-21', 'title' => 'Tiradentes'],
    ['date' => '2026-05-01', 'title' => 'Dia do Trabalho'],
    ['date' => '2026-06-04', 'title' => 'Corpus Christi (ponto facultativo)'],
    ['date' => '2026-09-07', 'title' => 'Independência do Brasil'],
    ['date' => '2026-10-12', 'title' => 'Nossa Senhora Aparecida'],
    ['date' => '2026-11-02', 'title' => 'Finados', 'description' => 'Não haverá aulas. As atividades retornam na terça-feira, 03/11.'],
    ['date' => '2026-11-15', 'title' => 'Proclamação da República'],
    ['date' => '2026-11-20', 'title' => 'Consciência Negra'],
    ['date' => '2026-12-25', 'title' => 'Natal'],
];

const LECTURES = [
    ['date' => '2026-09-17', 'title' => 'Palestra: Direito Digital e LGPD', 'time' => '19:30', 'place' => 'Auditório Central'],
    ['date' => '2026-10-26', 'title' => 'Abertura da Semana de Tecnologia', 'time' => '19:30', 'place' => 'Auditório Central', 'description' => 'Palestra de abertura sobre inteligência artificial aplicada ao desenvolvimento de software.'],
    ['date' => '2026-10-28', 'title' => 'Maratona de Programação', 'time' => '14:00', 'place' => 'Laboratório de Informática 2', 'description' => 'Competição em equipes, parte da Semana de Tecnologia.'],
    ['date' => '2026-11-12', 'title' => 'Palestra: Carreira em Tecnologia', 'time' => '19:30', 'place' => 'Auditório Central', 'description' => 'Promovida pelo núcleo de carreiras.'],
];

const WORKSHOPS = [
    ['date' => '2026-10-27', 'title' => 'Minicurso de Git e GitHub', 'time' => '19:00', 'place' => 'Laboratório de Informática 2', 'description' => 'Vagas limitadas. Inscrição na secretaria.'],
    ['date' => '2026-11-05', 'title' => 'Oficina de Currículo e LinkedIn', 'time' => '18:30', 'place' => 'Sala de Reuniões — Bloco 2'],
];

const SEMESTER_DEADLINES = [
    ['date' => '2026-08-03', 'title' => 'Início do semestre letivo'],
    ['date' => EVALUATION_DEADLINE, 'title' => 'Prazo da Avaliação Institucional (CPA)', 'place' => 'Portal do aluno', 'description' => 'Responda ao questionário até esta data.'],
    ['date' => '2026-12-11', 'title' => 'Último dia para registrar atividades complementares', 'place' => 'Portal do aluno'],
    ['date' => '2026-12-18', 'title' => 'Encerramento do semestre letivo'],
];

function calendarEvent(string $date, string $category, string $title, ?string $time = null, ?string $place = null, ?string $description = null): array
{
    return ['date' => $date, 'category' => $category, 'title' => $title, 'time' => $time, 'place' => $place, 'description' => $description];
}

function eventsInCategory(array $events, string $category): array
{
    return array_map(static fn (array $event): array => calendarEvent(...[...$event, 'category' => $category]), $events);
}

function examEvents(): array
{
    $disciplines = studentDisciplines();
    $firstClassStart = classSlots()[0]['start'];

    $studentExams = array_map(
        static fn (array $exam): array => calendarEvent(
            date: $exam['date'],
            category: 'prova',
            title: 'Prova — ' . $disciplines[$exam['discipline']]['short_name'],
            time: explode(' ', $exam['time'])[0],
            place: $disciplines[$exam['discipline']]['room'],
            description: $exam['type'] . ' • ' . $exam['time'] . '.',
        ),
        studentExams(),
    );

    return array_merge($studentExams, [
        calendarEvent(date: '2026-12-08', category: 'prova', title: 'Prova substitutiva', time: $firstClassStart, place: 'Bloco 1', description: 'Para alunos que não realizaram alguma prova do semestre.'),
        calendarEvent(date: '2026-12-10', category: 'prova', title: 'Exame final', time: $firstClassStart, place: 'Bloco 1'),
    ]);
}

function integratorProject(): ?array
{
    return studentDisciplines()[INTEGRATOR_PROJECT_KEY] ?? null;
}

function integratorProjectPresentations(): array
{
    $project = integratorProject();
    if ($project === null) {
        return [];
    }

    $description = 'Apresentação do projeto para a banca avaliadora, com cerca de 15 minutos por grupo.';

    return [
        calendarEvent(date: '2026-11-24', category: 'apresentacao', title: 'Apresentação do ' . $project['name'] . ' — Turma A', time: '19:00', place: 'Auditório Central', description: $description),
        calendarEvent(date: '2026-11-26', category: 'apresentacao', title: 'Apresentação do ' . $project['name'] . ' — Turma B', time: '19:00', place: 'Auditório Central', description: $description),
    ];
}

function academicDeadlines(): array
{
    $tuition = array_map(static fn (string $date): array => calendarEvent($date, 'prazo', 'Vencimento da mensalidade'), tuitionDueDates());
    $project = integratorProject();
    $projectReport = $project === null
        ? []
        : [calendarEvent(date: '2026-11-17', category: 'prazo', title: 'Entrega do relatório final — ' . $project['name'], place: 'Portal do aluno')];

    return array_merge($tuition, $projectReport, eventsInCategory(SEMESTER_DEADLINES, 'prazo'));
}

function calendarEvents(): array
{
    return array_merge(
        eventsInCategory(HOLIDAYS, 'feriado'),
        examEvents(),
        integratorProjectPresentations(),
        eventsInCategory(LECTURES, 'palestra'),
        eventsInCategory(WORKSHOPS, 'oficina'),
        academicDeadlines(),
    );
}

function nextCalendarEvent(): ?array
{
    $upcoming = array_filter(calendarEvents(), static fn (array $event): bool => $event['date'] >= SIMULATED_TODAY);
    usort($upcoming, static fn (array $a, array $b): int => [$a['date'], $a['time'] ?? ''] <=> [$b['date'], $b['time'] ?? '']);
    return $upcoming[0] ?? null;
}
