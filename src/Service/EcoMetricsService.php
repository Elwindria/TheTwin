<?php

namespace App\Service;

use App\Repository\UserActionRepository;
use App\ValueObject\WeekRange;
use App\Entity\User;

class EcoMetricsService
{
    public function __construct(
        private UserActionRepository $userActionRepository,
    ) 
    {

    }

    public function getTotalTwinCo2ForUserForThisWeek(User $user): int
    {
        $week = WeekRange::current();

        return $this->userActionRepository->getTotalTwinCo2ForUserForThisWeek(
            $user,
            $week->getStart(),
            $week->getEnd(),
        );
    }

    public function getTotalAllTwinsCo2ForAllUsersForThisWeek(): int
    {
        $week = WeekRange::current();

        return $this->userActionRepository->getTotalTwinCo2ForAllUsersForThisWeek(
            $week->getStart(),
            $week->getEnd(),
        );
    }
}