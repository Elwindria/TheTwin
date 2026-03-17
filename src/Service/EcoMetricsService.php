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

    public function getWeeklySummaryForUser(User $user): array
    {
        $week = WeekRange::current();

        $userActions = $this->userActionRepository->getAllWeeklyUserActionsForUser(
                $user,
                $week->getStart(),
                $week->getEnd(),
            );

            $summary = [
                'totalTwinCo2Produced' => 0.0,
                'totalCo2Saved' => 0.0,
                'totalScore' => 0,
                'totalActionsCount' => 0,
                'categories' => [],
            ];

            foreach ($userActions as $userAction) {
                $category = $userAction->getCategory();
                $categoryId = $category->getId();
                $categoryName = $category->getName();

                $twinCo2Produced = (float) $userAction->getFinalTwinCo2Produced();
                $co2Saved = (float) $userAction->getFinalCo2Saved();
                $score = (int) $userAction->getScore();

                $summary['totalTwinCo2Produced'] += $twinCo2Produced;
                $summary['totalCo2Saved'] += $co2Saved;
                $summary['totalScore'] += $score;
                $summary['totalActionsCount']++;

                if (!isset($summary['categories'][$categoryId])) {
                    $summary['categories'][$categoryId] = [
                        'categoryId' => $categoryId,
                        'categoryName' => $categoryName,
                        'totalTwinCo2Produced' => 0.0,
                        'totalCo2Saved' => 0.0,
                        'totalScore' => 0,
                        'totalActionsCount' => 0,
                    ];
                }

                $summary['categories'][$categoryId]['totalTwinCo2Produced'] += $twinCo2Produced;
                $summary['categories'][$categoryId]['totalCo2Saved'] += $co2Saved;
                $summary['categories'][$categoryId]['totalScore'] += $score;
                $summary['categories'][$categoryId]['totalActionsCount']++;
            }

            $summary['categories'] = array_values($summary['categories']);

            return $summary;
    }

    public function getSummaryForUser(User $user): array
    {

        $userActions = $this->userActionRepository->getAllUserActionsForUser(
                $user
            );

            $summary = [
                'totalTwinCo2Produced' => 0.0,
                'totalCo2Saved' => 0.0,
                'totalScore' => 0,
                'totalActionsCount' => 0,
                'categories' => [],
            ];

            foreach ($userActions as $userAction) {
                $category = $userAction->getCategory();
                $categoryId = $category->getId();
                $categoryName = $category->getName();

                $twinCo2Produced = (float) $userAction->getFinalTwinCo2Produced();
                $co2Saved = (float) $userAction->getFinalCo2Saved();
                $score = (int) $userAction->getScore();

                $summary['totalTwinCo2Produced'] += $twinCo2Produced;
                $summary['totalCo2Saved'] += $co2Saved;
                $summary['totalScore'] += $score;
                $summary['totalActionsCount']++;

                if (!isset($summary['categories'][$categoryId])) {
                    $summary['categories'][$categoryId] = [
                        'categoryId' => $categoryId,
                        'categoryName' => $categoryName,
                        'totalTwinCo2Produced' => 0.0,
                        'totalCo2Saved' => 0.0,
                        'totalScore' => 0,
                        'totalActionsCount' => 0,
                    ];
                }

                $summary['categories'][$categoryId]['totalTwinCo2Produced'] += $twinCo2Produced;
                $summary['categories'][$categoryId]['totalCo2Saved'] += $co2Saved;
                $summary['categories'][$categoryId]['totalScore'] += $score;
                $summary['categories'][$categoryId]['totalActionsCount']++;
            }

            $summary['categories'] = array_values($summary['categories']);

            return $summary;
    }
}