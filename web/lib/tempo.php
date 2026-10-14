<?php

const TIMEZONE = 'America/Sao_Paulo';

function now(): DateTimeImmutable
{
    return new DateTimeImmutable('now', new DateTimeZone(TIMEZONE));
}

function today(): DateTimeImmutable
{
    return now()->setTime(0, 0);
}

function parseDateTime(string $dateTime): DateTimeImmutable
{
    return new DateTimeImmutable($dateTime, new DateTimeZone(TIMEZONE));
}

function dateFromToday(int $days): string
{
    return today()->modify(sprintf('%+d days', $days))->format('Y-m-d');
}

function dateTimeFromToday(int $days, string $time): string
{
    return dateFromToday($days) . 'T' . $time;
}

function daysAgo(DateTimeImmutable $date): int
{
    return (int) $date->setTime(0, 0)->diff(today())->format('%r%a');
}

function relativeDateLabel(DateTimeImmutable $date): string
{
    $days = daysAgo($date);
    $time = $date->format('H:i');

    return match (true) {
        $days === 0 => "Hoje às {$time}",
        $days === 1 => "Ontem às {$time}",
        $days > 1 && $days < 7 => "Há {$days} dias",
        default => $date->format('d/m/Y'),
    };
}