<?php
require_once __DIR__ . '/dados.php';

const WEEKDAYS = [1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta', 6 => 'Sábado', 7 => 'Domingo'];

const MONTH_ABBREVIATIONS = [1 => 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];

function studentFirstName(): string
{
    return explode(' ', STUDENT['name'])[0];
}

function studentInitials(): string
{
    $names = explode(' ', STUDENT['name']);
    return mb_substr($names[0], 0, 1) . mb_substr(end($names), 0, 1);
}

function disciplineAverage(array $discipline): float
{
    return array_sum($discipline['grades']) / count($discipline['grades']);
}

function isDisciplineGradingComplete(array $discipline): bool
{
    return count($discipline['grades']) === 2;
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
    $totalClasses = $discipline['attended'] + $discipline['absences'];
    return (int) round($discipline['attended'] / $totalClasses * 100);
}

function attendanceStatus(array $discipline): string
{
    return disciplineAttendance($discipline) >= MINIMUM_ATTENDANCE ? 'Regular' : 'Atenção';
}

function overallAverage(): float
{
    return array_sum(array_map('disciplineAverage', DISCIPLINES)) / count(DISCIPLINES);
}

function overallAttendance(): int
{
    $attended = array_sum(array_column(DISCIPLINES, 'attended'));
    $absences = array_sum(array_column(DISCIPLINES, 'absences'));
    return (int) round($attended / ($attended + $absences) * 100);
}

function upcomingExams(): array
{
    return array_values(array_filter(EXAMS, static fn (array $exam): bool => $exam['date'] >= SIMULATED_TODAY));
}

function examStatus(array $exam): string
{
    return $exam === upcomingExams()[0] ? 'Próxima' : 'Agendada';
}

function classesOn(string $date): array
{
    $weekday = WEEKDAYS[(int) date('N', strtotime($date))];
    return WEEKLY_SCHEDULE[$weekday] ?? [];
}

function firstClassOn(string $date): ?array
{
    $slots = array_filter(classesOn($date));
    if ($slots === []) {
        return null;
    }

    $disciplineKey = reset($slots);
    $disciplineSlots = array_keys(classesOn($date), $disciplineKey, true);

    return [
        'discipline' => DISCIPLINES[$disciplineKey],
        'start' => CLASS_SLOTS[min($disciplineSlots)]['start'],
        'end' => CLASS_SLOTS[max($disciplineSlots)]['end'],
    ];
}

function approvedComplementaryHours(): int
{
    return complementaryHoursWithStatus('Deferido');
}

function complementaryHoursWithStatus(string $status): int
{
    $activities = array_filter(COMPLEMENTARY_ACTIVITIES, static fn (array $activity): bool => $activity['status'] === $status);
    return array_sum(array_column($activities, 'hours'));
}

function percentage(int|float $part, int|float $total): int
{
    return (int) round($part / $total * 100);
}

function statusBadge(string $status): string
{
    return STATUS_BADGES[$status] ?? 'text-bg-secondary';
}

function weekdayName(string $date): string
{
    $weekdayNumber = (int) date('N', strtotime($date));
    return WEEKDAYS[$weekdayNumber] . ($weekdayNumber <= 5 ? '-feira' : '');
}

function formatDate(string $date): string
{
    return date('d/m/Y', strtotime($date));
}

function formatShortDate(string $date): string
{
    $timestamp = strtotime($date);
    return date('d', $timestamp) . ' ' . MONTH_ABBREVIATIONS[(int) date('n', $timestamp)];
}

function formatGrade(float $grade): string
{
    return number_format($grade, 1, ',', '.');
}

function formatHours(int $hours): string
{
    return number_format($hours, 0, ',', '.') . 'h';
}

function formatCurrency(float $value): string
{
    return 'R$ ' . number_format($value, 2, ',', '.');
}