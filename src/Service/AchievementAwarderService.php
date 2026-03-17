<?php

namespace App\Service;

use App\Service\EcoMetricsService;

class AchievementAwarderService
{
    public function __construct(
        private EcoMetricsService $EcoMetricsService,
    ) 
    {

    }

    public function awardAchievementByUsers(): void
    {
        $summaryByAllUsers = $this->EcoMetricsService->getSummaryByAllUsers();

        foreach ($summaryByAllUsers as $summaryByUser){
            
        }
    }
}