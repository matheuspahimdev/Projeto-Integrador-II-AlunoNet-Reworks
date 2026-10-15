<?php

const WEEKDAYS = [1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta', 6 => 'Sábado', 7 => 'Domingo'];

const WEEKDAY_ABBREVIATIONS = ['Segunda' => 'Seg.', 'Terça' => 'Ter.', 'Quarta' => 'Qua.', 'Quinta' => 'Qui.', 'Sexta' => 'Sex.', 'Sábado' => 'Sáb.', 'Domingo' => 'Dom.'];

const MONTH_NAMES = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

const MONTH_ABBREVIATIONS = [1 => 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];

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

function formatAmount(float $value): string
{
    return number_format($value, 2, ',', '.');
}

function formatCurrency(float $value): string
{
    return 'R$ ' . formatAmount($value);
}

function percentage(int|float $part, int|float $total): int
{
    return $total <= 0 ? 0 : (int) round($part / $total * 100);
}
function formatDayMonth(string $date): string
{
    return date('d/m', strtotime($date));
}

function pluralize(int $count, string $singular, string $plural): string
{
    return $count . ' ' . ($count === 1 ? $singular : $plural);
}
