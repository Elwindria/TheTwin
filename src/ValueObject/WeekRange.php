<?php

namespace App\ValueObject;

final class WeekRange
{
    private \DateTimeImmutable $start;
    private \DateTimeImmutable $end;

    public function __construct(\DateTimeImmutable $start, \DateTimeImmutable $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public static function fromDate(
        \DateTimeImmutable $date,
        string $timezone = 'Europe/Paris'
    ): self {
        // On force la timezone Paris
        $tz = new \DateTimeZone($timezone);
        $date = $date->setTimezone($tz);

        // 1. On récupère le jour de la semaine (1 = lundi, 7 = dimanche)
        $dayOfWeek = (int) $date->format('N');

        // 2. On recule jusqu'au lundi
        $start = $date
            ->modify('-' . ($dayOfWeek - 1) . ' days')
            ->setTime(0, 0, 0);

        // 3. Fin = lundi suivant 00:00
        $end = $start->modify('+7 days');

        return new self($start, $end);
    }

    public static function current(string $timezone = 'Europe/Paris'): self
    {
        return self::fromDate(new \DateTimeImmutable(), $timezone);
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    public function contains(\DateTimeImmutable $date): bool
    {
        return $date >= $this->start && $date < $this->end;
    }
}