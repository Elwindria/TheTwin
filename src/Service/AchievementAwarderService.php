<?php

namespace App\Service;

use App\Service\EcoMetricsService;

class AchievementAwarderService
{
    public function __construct(
        private EcoMetricsService $ecoMetricsService,
    ) 
    {

    }

    public function awardAchievementByUsers(): void
    {
            $dataByUsers = $this->ecoMetricsService->getSummaryByAllUsers();

            foreach ($dataByUsers as $userData) {
                $userId = $userData['user_id'];
                $summary = $userData['summary'];
                $ownedCodes = $userData['owned_achievement_codes'];
                $rules = $userData['rules'];

                foreach ($rules as $rule) {
                    $type = $rule['type'];
                    $code = $rule['code'];
                    $threshold = $rule['threshold'];

                    if ($summary[$type] >= $threshold) {
                        
                    }
                }
            }
    }
}