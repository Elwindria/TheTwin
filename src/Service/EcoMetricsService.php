<?php

namespace App\Service;

use App\Repository\UserActionRepository;

class EcoMetricsService
{
    public function __construct(
        private UserActionRepository $userActionRepository
    ) 
    {

    }

    public function getTotalScoreAllUsers(): int
    {
        return $this->userActionRepository->getTotalScore();
    }
}