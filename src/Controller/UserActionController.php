<?php

namespace App\Controller;

use App\Entity\UserAction;
use App\Repository\CategoryRepository;
use App\Repository\EcoActionRepository;
use App\Repository\EcoActionVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserActionController extends AbstractController
{
    #[Route('/user-action', name: 'app_user_action_store', methods: ['POST'])]
    public function store(
        Request $request,
        CategoryRepository $categoryRepository,
        EcoActionRepository $ecoActionRepository,
        EcoActionVariantRepository $ecoActionVariantRepository,
        EntityManagerInterface $entityManager
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

        return $this->json([
            'status' => 'ok',
            'message' => 'Action enregistrée avec succès.',
        ]);
    }
}
