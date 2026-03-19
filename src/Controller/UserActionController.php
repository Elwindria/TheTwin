<?php

namespace App\Controller;

use App\Entity\UserAction;
use App\Repository\CategoryRepository;
use App\Repository\EcoActionRepository;
use App\Repository\EcoActionVariantRepository;
use App\Service\WeeklyResolutionService;
use App\Repository\UserActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
final class UserActionController extends AbstractController
{
    #[Route('/user-action', name: 'app_user_action_store', methods: ['POST'])]
    public function store(
        Request $request,
        CategoryRepository $categoryRepository,
        EcoActionRepository $ecoActionRepository,
        EcoActionVariantRepository $ecoActionVariantRepository,
        EntityManagerInterface $entityManager,
        WeeklyResolutionService $weeklyResolutionService
    ): JsonResponse {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'status' => 'error',
                'message' => 'Utilisateur non connecté.',
            ], 401);
        }

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json([
                'status' => 'error',
                'message' => 'Payload invalide.',
            ], 400);
        }

        $categoryId = $data['categoryId'] ?? null;
        $ecoActionId = $data['ecoActionId'] ?? null;
        $ecoActionVariantId = $data['ecoActionVariantId'] ?? null;
        $km = $data['km'] ?? null;

        if (!$categoryId || !$ecoActionId || !$ecoActionVariantId) {
            return $this->json([
                'status' => 'error',
                'message' => 'Données manquantes.',
            ], 400);
        }

        $category = $categoryRepository->find($categoryId);
        $ecoAction = $ecoActionRepository->find($ecoActionId);
        $ecoActionVariant = $ecoActionVariantRepository->find($ecoActionVariantId);

        if (!$category || !$ecoAction || !$ecoActionVariant) {
            return $this->json([
                'status' => 'error',
                'message' => 'Catégorie, action ou variante introuvable.',
            ], 404);
        }

        $finalScore = (int) $ecoActionVariant->getScore();
        $finalCo2Saved = (float) $ecoActionVariant->getCo2Saved();
        $finalTwinCo2Produced = (float) $ecoActionVariant->getTwinCo2Produced();

        if ($ecoAction->getInputType() === 'km') {
            if (!$km || $km <= 0) {
                return $this->json([
                    'status' => 'error',
                    'message' => 'Le nombre de kilomètres est invalide.',
                ], 400);
            }

            $finalScore *= (int) $km;
            $finalCo2Saved *= (float) $km;
            $finalTwinCo2Produced *= (float) $km;
        }

        $userAction = new UserAction();
        $userAction->setUser($user);
        $userAction->setCategory($category);
        $userAction->setEcoAction($ecoAction);
        $userAction->setEcoActionVariant($ecoActionVariant);
        $userAction->setScore($finalScore);
        $userAction->setFinalCo2Saved((string) $finalCo2Saved);
        $userAction->setFinalTwinCo2Produced((string) $finalTwinCo2Produced);
        $userAction->setCreatedAt(new \DateTimeImmutable());
        $userAction->setIsAvailable(true);

        $entityManager->persist($userAction);
        $entityManager->flush();

        $weeklyResolutionService->awardAchievementsForUser($user);

        return $this->json([
            'status' => 'ok',
            'message' => 'Action enregistrée avec succès.',
        ]);
    }

    #[Route('/api/twin/carbon-by-category', name: 'app_twin_carbon_by_category', methods: ['GET'])]
    public function getTwinCarbonByCategory(UserActionRepository $userActionRepo): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'status' => 'error',
                'message' => 'Utilisateur non connecté.',
            ], 401);
        }

        $allActions = $userActionRepo->getAllUserActionsForUser($user);

        // Calculate twin CO2 by category
        $twinCo2ByCategory = [];
        foreach ($allActions as $ua) {
            $cat = $ua->getCategory()->getName();
            $twinCo2ByCategory[$cat] = ($twinCo2ByCategory[$cat] ?? 0) + (float) $ua->getFinalTwinCo2Produced();
        }

        // Format data for response (converting to tonnes)
        $data = array_map(
            fn($name, $co2) => ['category' => $name, 'co2' => round($co2 / 1000, 1)],
            array_keys($twinCo2ByCategory),
            array_values($twinCo2ByCategory)
        );

        $totalTwinCo2 = array_sum(array_values($twinCo2ByCategory));

        return $this->json([
            'status' => 'ok',
            'data' => $data,
            'total' => round($totalTwinCo2 / 1000, 1),
        ]);
    }
}

