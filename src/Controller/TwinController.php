<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Service\AchievementAwarderService;

#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
final class TwinController extends AbstractController
{
    #[Route('/twin', name: 'app_twin')]
    public function index(
        CategoryRepository $categoryRepository,
        AchievementAwarderService $AchievementAwarderService
    ): Response
    {
        $categories = $categoryRepository->findAll();

        $actionsData = [];

        foreach ($categories as $category) {
            $actions = [];

            foreach ($category->getEcoActions() as $ecoAction) {
                $variants = [];

                foreach ($ecoAction->getEcoActionVariants() as $variant) {
                    $variants[] = [
                        'id' => $variant->getId(),
                        'name' => $variant->getName(),
                        'co2Saved' => $variant->getCo2Saved(),
                        'twinCo2Produced' => $variant->getTwinCo2Produced(),
                        'score' => $variant->getScore(),
                    ];
                }

                $actions[] = [
                    'id' => $ecoAction->getId(),
                    'name' => $ecoAction->getName(),
                    'inputType' => $ecoAction->getInputType(),
                    'variants' => $variants,
                ];
            }

            $actionsData[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'actions' => $actions,
            ];
        }

        $AchievementAwarderService->awardAchievementByUsers();

        return $this->render('twin/index.html.twig', [
            'actionsData' => $actionsData,
        ]);
    }
}
