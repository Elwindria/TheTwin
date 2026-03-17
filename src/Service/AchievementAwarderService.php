<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\AchievementRepository;
use App\Service\EcoMetricsService;
use App\Entity\UserAchievement;
use Doctrine\ORM\EntityManagerInterface;


class AchievementAwarderService
{
    public function __construct(
        private EcoMetricsService $ecoMetricsService,
        private UserRepository $userRepository,
        private AchievementRepository $achievementRepository,
        private EntityManagerInterface $entityManager,
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

        $this->entityManager->flush();

        $patata = $this->achievementRepository->findAll();
        dd($patata);
    }
}