<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\AchievementRepository;
use App\Service\EcoMetricsService;
use App\Entity\UserAchievement;
use App\Entity\WeeklyChallenge;
use App\Repository\UserActionRepository;
use App\Repository\WeeklyChallengeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\ValueObject\WeekRange;


class WeeklyResolutionService
{
    public function __construct(
        private EcoMetricsService $ecoMetricsService,
        private UserRepository $userRepository,
        private AchievementRepository $achievementRepository,
        private EntityManagerInterface $entityManager,
        private WeeklyChallengeRepository $weeklyChallengeRepository,
        private UserActionRepository $userActionRepository
    ) 
    {

    }

    public function resolveCurrentWeek(): void
    {
        $week = WeekRange::lastCompleteWeek();

        $weeklyChallenge = $this->weeklyChallengeRepository->findOneByPeriod(
            $week->getStart(),
            $week->getEnd()
        );

        if (!$weeklyChallenge) {
            throw new \RuntimeException('Aucun WeeklyChallenge trouvé pour la semaine courante.');
        }

        $actualScore = $this->userActionRepository->getTotalScoreForWeek(
            $week->getStart(),
            $week->getEnd()
        );

        $hasWon = $actualScore >= $weeklyChallenge->getTargetScore();

        $this->setVictory($actualScore, $weeklyChallenge, $hasWon);
        $hasWon ? $this->incrementWinStreakForParticipantsOfLastCompleteWeek($week) : null;
        $this->createNewWeeklyChallenge($actualScore);
        $this->awardAchievementByUsers();

        $this->entityManager->flush();
    }

    private function setVictory(
        int $actualScore,
        WeeklyChallenge $weeklyChallenge,
        bool $hasWon
    ): void
    {
        $weeklyChallenge->setActualScore((string) $actualScore);
        $weeklyChallenge->setHasWon($hasWon);
        $weeklyChallenge->setIsResolved(true);
    }

    public function incrementWinStreakForParticipantsOfLastCompleteWeek(
        WeekRange $week,
    ): void
    {
        //trouve les users qui ont au moins 1 actions dans la semaine
        $users = $this->userRepository->findDistinctUsersForWeek(
            $week->getStart(),
            $week->getEnd()
        );

        foreach ($users as $user) {
            $currentWinStreak = $user->getWinstreak() ?? 0;
            $user->setWinstreak($currentWinStreak + 1);
        }
    }

    public function createNewWeeklyChallenge(int $actualScore): void
    {
        $week = WeekRange::current();

        // Base = score de la semaine précédente
        $baseScore = $actualScore;

        //Réduction fixe -5% pour éviter une incrémentation infini
        $baseScore = $baseScore * 0.95;

        // Difficulté aléatoire
        $difficulties = [
            'easy' => 0.9,
            'normal' => 1.0,
            'hard' => 1.2,
        ];

        $difficulty = array_rand($difficulties);
        $multiplier = $difficulties[$difficulty];

        //Score final à battre
        $targetScore = (int) round($baseScore * $multiplier);

        $weeklyChallenge = new WeeklyChallenge();
        $weeklyChallenge->setStartAt($week->getStart());
        $weeklyChallenge->setEndAt($week->getEnd());
        $weeklyChallenge->setTargetScore($targetScore);
        $weeklyChallenge->setActualScore(0);
        $weeklyChallenge->setDifficulty($difficulty);
        $weeklyChallenge->setDifficultyMultiplier($multiplier);
        $weeklyChallenge->setHasWon(false);
        $weeklyChallenge->setIsResolved(false);

        $this->entityManager->persist($weeklyChallenge);
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

                if (($summary[$type] ?? 0) >= $threshold
                    && !in_array($code, $ownedCodes, true))
                {
                    $user = $this->userRepository->find($userId);
                    $achievement = $this->achievementRepository->findOneBy([
                        'code' => $code,
                    ]);

                    $userAchievement = new UserAchievement();
                    $userAchievement->setUser($user);
                    $userAchievement->setAchievement($achievement);
                    $userAchievement->setAwardedAt(new \DateTimeImmutable());

                    $this->entityManager->persist($userAchievement);

                    //eviter les doublons d'attribution
                    $ownedCodes[] = $code;
                }
            }
        }
    }
}