<?php
require_once __DIR__ . '/autenticacao.php';
require_once __DIR__ . '/formatacao.php';

// Dados acadêmicos do aluno logado, vindos de ACADEMIC_RECORDS.
function academicRecord(): array
{
    return ACADEMIC_RECORDS[currentStudent()['registration']];
}

function studentDisciplines(): array
{
    return academicRecord()['disciplines'];
}

function classSlots(): array
{
    return academicRecord()['class_slots'];
}

function weeklySchedule(): array
{
    return academicRecord()['weekly_schedule'];
}

function studentExams(): array
{
    return academicRecord()['exams'];
}

function complementaryActivities(): array
{
    return academicRecord()['complementary_activities'];
}

function curriculumComponents(): array
{
    return academicRecord()['curriculum'];
}

function studentFirstName(): string
{
    return explode(' ', currentStudent()['name'])[0];
}

function studentInitials(): string
{
    $names = explode(' ', currentStudent()['name']);
    return mb_substr($names[0], 0, 1) . mb_substr(end($names), 0, 1);
}

function average(array $values): float
{
    return $values === [] ? 0.0 : array_sum($values) / count($values);
}

function disciplineAverage(array $discipline): float
{
    return average($discipline['grades']);
}

function isDisciplineGradingComplete(array $discipline): bool
{
    return count($discipline['grades']) === GRADES_PER_SEMESTER;
}

function disciplineStatus(array $discipline): string
{
    if (!isDisciplineGradingComplete($discipline)) {
        return 'Em andamento';
    }
    return disciplineAverage($discipline) >= PASSING_GRADE ? 'Aprovado' : 'Reprovado';
}

function disciplineAttendance(array $discipline): int
{
    return percentage($discipline['attended'], $discipline['attended'] + $discipline['absences']);
}

function attendanceStatus(array $discipline): string
{
    return disciplineAttendance($discipline) >= MINIMUM_ATTENDANCE ? 'Regular' : 'Atenção';
}

function overallAverage(): float
{
    return average(array_map('disciplineAverage', studentDisciplines()));
}

function overallAttendance(): int
{
    $attended = array_sum(array_column(studentDisciplines(), 'attended'));
    $absences = array_sum(array_column(studentDisciplines(), 'absences'));
    return percentage($attended, $attended + $absences);
}

function upcomingExams(): array
{
    return array_values(array_filter(studentExams(), static fn (array $exam): bool => $exam['date'] >= SIMULATED_TODAY));
}

function examStatus(array $exam): string
{
    return $exam === upcomingExams()[0] ? 'Próxima' : 'Agendada';
}

// Resumo da semana para a página inicial: disciplinas de cada dia, sem repetir os horários seguidos.
function weekSummary(): array
{
    $todayWeekday = WEEKDAYS[(int) today()->format('N')];

    return array_map(
        static fn (string $weekday, array $disciplineKeys): array => [
            'short_name' => WEEKDAY_ABBREVIATIONS[$weekday],
            'is_today' => $weekday === $todayWeekday,
            'classes' => array_map(
                static fn (string $key): array => studentDisciplines()[$key],
                array_values(array_unique(array_filter($disciplineKeys))),
            ),
        ],
        array_keys(weeklySchedule()),
        weeklySchedule(),
    );
}

// Legenda do horário: agrupa dias seguidos que acontecem no mesmo local.
function scheduleLegend(): array
{
    $disciplines = studentDisciplines();
    $groups = [];

    foreach (weeklySchedule() as $weekday => $disciplineKeys) {
        $rooms = array_unique(array_map(
            static fn (string $key): string => $disciplines[$key]['online'] ? 'Online' : $disciplines[$key]['room'],
            array_filter($disciplineKeys),
        ));
        $label = $rooms === [] ? 'sem aula' : implode(' / ', $rooms);
        $last = array_key_last($groups);

        if ($last !== null && $groups[$last]['label'] === $label) {
            $groups[$last]['days'][] = $weekday;
        } else {
            $groups[] = ['days' => [$weekday], 'label' => $label];
        }
    }

    return array_map(static fn (array $group): array => [
        'icon' => match ($group['label']) {
            'Online' => 'bi-camera-video',
            'sem aula' => 'bi-calendar-x',
            default => 'bi-building',
        },
        'text' => (count($group['days']) === 1
            ? $group['days'][0]
            : WEEKDAY_ABBREVIATIONS[$group['days'][0]] . ' a ' . WEEKDAY_ABBREVIATIONS[end($group['days'])]) . ': ' . $group['label'],
    ], $groups);
}

function approvedComplementaryHours(): int
{
    return complementaryHoursWithStatus(ACTIVITY_APPROVED);
}

function complementaryHoursWithStatus(string $status): int
{
    $activities = array_filter(complementaryActivities(), static fn (array $activity): bool => $activity['status'] === $status);
    return array_sum(array_column($activities, 'hours'));
}

function statusBadge(string $status): string
{
    return STATUS_BADGES[$status] ?? 'text-bg-secondary';
}