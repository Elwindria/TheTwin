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

    public function getTotalScore(): int
    {
        return $this->userActionRepository->getTotalScore();
    }
}