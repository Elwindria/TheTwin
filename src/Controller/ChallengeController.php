<?php

namespace App\Controller;

use App\Repository\ChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class ChallengeController extends AbstractController
{
    #[Route('/api/challenges', name: 'app_challenges_list', methods: ['GET'])]
    public function list(ChallengeRepository $challengeRepository): JsonResponse
    {
        $challenges = $challengeRepository->findAll();

        $data = array_map(function ($challenge) {
            return [
                'id' => $challenge->getId(),
                'title' => $challenge->getTitle(),
                'description' => $challenge->getDescription(),
                'difficulty' => $challenge->getDifficulty(),
                'category' => $challenge->getCategory()->getName(),
                'categoryId' => $challenge->getCategory()->getId(),
                'actions' => array_map(function ($action) {
                    return [
                        'id' => $action->getId(),
                        'name' => $action->getName(),
                        'categoryId' => $action->getCategory()->getId(),
                        'inputType' => $action->getInputType(),
                    ];
                }, $challenge->getEcoActions()->toArray()),
                'variants' => array_map(function ($variant) {
                    return [
                        'id' => $variant->getId(),
                        'name' => $variant->getName(),
                        'ecoActionId' => $variant->getEcoAction()->getId(),
                        'co2Saved' => $variant->getCo2Saved(),
                        'twinCo2Produced' => $variant->getTwinCo2Produced(),
                        'score' => $variant->getScore(),
                    ];
                }, $challenge->getEcoActionVariants()->toArray()),
            ];
        }, $challenges);

        return $this->json([
            'status' => 'ok',
            'data' => $data,
        ]);
    }
}
