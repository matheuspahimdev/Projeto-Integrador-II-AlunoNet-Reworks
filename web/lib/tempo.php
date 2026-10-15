<?php

const TIMEZONE = 'America/Sao_Paulo';

// Data fixa do protótipo: provas, boletos, avisos, empréstimos e o JS das páginas partem deste "hoje".
const SIMULATED_TODAY = '2026-10-14';

date_default_timezone_set(TIMEZONE);

function today(): DateTimeImmutable
{
    return parseDateTime(SIMULATED_TODAY);
}

function parseDateTime(string $dateTime): DateTimeImmutable
{
    return new DateTimeImmutable($dateTime, new DateTimeZone(TIMEZONE));
}

function daysAgo(DateTimeImmutable $date): int
{
    return (int) $date->setTime(0, 0)->diff(today())->format('%r%a');
}

// Dias de hoje até a data: positivo no futuro, negativo no passado.
function daysUntil(string $date): int
{
    return -daysAgo(parseDateTime($date));
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
