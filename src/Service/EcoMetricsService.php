<?php

namespace App\Service;

use App\Repository\UserActionRepository;
use App\ValueObject\WeekRange;
use App\Entity\User;
use App\Repository\AchievementRepository;
use App\Repository\UserAchievementRepository;
use App\Repository\UserRepository;
use Doctrine\Inflector\Rules\English\Rules;

class EcoMetricsService
{
    public function __construct(
        private UserActionRepository $userActionRepository,
        private UserAchievementRepository $userAchievementRepository,
        private AchievementRepository $achievementRepository,
        private UserRepository $userRepository,
    ) 
    {

    }

    public function getWeeklySummaryForUser(User $user): array
    {
        $week = WeekRange::current();

        $userActions = $this->userActionRepository->getAllWeeklyUserActionsForUser
            (
                $user,
                $week->getStart(),
                $week->getEnd(),
            );

        return $this->buildSummaryFromUserActions($userActions);
    }

    public function getSummaryForUser(User $user): array
    {
        $userActions = $this->userActionRepository->getAllUserActionsForUser($user);

        return $this->buildSummaryFromUserActions($userActions);
    }

    public function getWeeklySummaryForAllUsers(): array
    {
        $week = WeekRange::current();

        $usersActions = $this->userActionRepository->getAllWeeklyUserActionsForAllUsers
        (
            $week->getStart(),
            $week->getEnd(),
        );

        return $this->buildSummaryFromUserActions($usersActions);
    }

    public function getSummaryForAllUsers(): array
    {
        $usersActions = $this->userActionRepository->getAllUserActionsForAllUsers();

        return $this->buildSummaryFromUserActions($usersActions);
    }

    private function buildSummaryFromUserActions(array $userActions): array
    {
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

    public function getSummaryByAllUsers(): array
    {
        $actions = $this->userActionRepository->findAllActionWithUserAndCategory();
        $userAchievements = $this->userAchievementRepository->findAllWithUserAndAchievement();
        $achievements = $this->achievementRepository->findAllActiveOrdered();
        $userWinstreak = $this->userRepository->findAllWithWinstreak();

        $actionsByUsers = $this->getActionsByUsers($actions);
        $ownedAchievementsByUser = $this->getOwnedAchievementsByUser($userAchievements);
        $winstreakByUser = $this->getWinstreakByUser($userWinstreak);
        $rules = $this->getRules($achievements);


        $summaryByUsers = [];

        foreach ($actionsByUsers as $userId => $userActions) {

            $achievementCount = count($ownedAchievementsByUser[$userId] ?? []);
            $winstreak = $winstreakByUser[$userId] ?? 0;

            $summaryByUsers[] = [
                'user_id' => $userId,
                'summary' => $this->buildSummaryAchievementFromUserActions(
                    $userActions,
                    $achievementCount,
                    $winstreak,
                    $rules
                ),
                'owned_achievement_codes' => $ownedAchievementsByUser[$userId] ?? [],
                'rules' => $rules,
            ];
        }

        return $summaryByUsers;
    }

    private function getActionsByUsers(array $actions): array
    {
        $actionsByUsers = [];

        foreach ($actions as $action) {
            $userId = $action->getUser()->getId();
            $actionsByUsers[$userId][] = $action;
        }

        return $actionsByUsers;
    }

    private function getOwnedAchievementsByUser(array $userAchievements): array
    {
        $ownedAchievementsByUser = [];

        foreach ($userAchievements as $userAchievement) {
            $userId = $userAchievement->getUser()->getId();
            $achievementCode = $userAchievement->getAchievement()->getCode();

            $ownedAchievementsByUser[$userId][] = $achievementCode;
        }

        return $ownedAchievementsByUser;
    }

    private function getRules(array $achievements): array
    {
        $rules = [];

        foreach ($achievements as $achievement) {
            $rules[] = [
                'id' => $achievement->getId(),
                'code' => $achievement->getCode(),
                'type' => $achievement->getType(),
                'threshold' => $achievement->getThreshold(),
            ];
        }

        return $rules;
    }

    private function getWinstreakByUser(array $users): array
    {
        $winstreakByUser = [];

        foreach ($users as $user) {
            $winstreakByUser[$user['id']] = $user['winstreak'];
        }

        return $winstreakByUser;
    }

    private function buildSummaryAchievementFromUserActions(
        array $userActions,
        int $achievementCount,
        int $winstreak,
        array $rules
    ): array
    {
        $summary = [];

        // Initialise toutes les clés attendues depuis les rules
        foreach ($rules as $rule) {
            $type = $rule['type'];

            if (!isset($summary[$type])) {
                $summary[$type] = 0;
            }
        }

        // Valeurs globales
        $summary['achievement_count'] = $achievementCount;
        $summary['victory_count'] = $winstreak;
        $summary['total_score'] = $summary['total_score'] ?? 0;

        // Mapping entre nom de catégorie et type d'achievement
        $categoryTypeMap = [
            'Déplacement' => 'category_deplacement',
            'Alimentation' => 'category_alimentation',
            'Consommation' => 'category_consommation',
            'Énergie' => 'category_energie',
            'Energie' => 'category_energie',
            'Numérique' => 'category_numerique',
            'Numerique' => 'category_numerique',
            'Déchets' => 'category_dechets',
            'Dechets' => 'category_dechets',
            'Engagement écologique' => 'category_engagement_ecologique',
            'Engagement ecologique' => 'category_engagement_ecologique',
        ];

        foreach ($userActions as $userAction) {
            $score = (int) $userAction->getScore();
            $summary['total_score'] += $score;

            $categoryName = $userAction->getCategory()?->getName();

            if ($categoryName && isset($categoryTypeMap[$categoryName])) {
                $categoryType = $categoryTypeMap[$categoryName];
                $summary[$categoryType] += $score;
            }
        }

        return $summary;
    }
}