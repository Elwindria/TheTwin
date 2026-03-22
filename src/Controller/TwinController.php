<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\UserActionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
final class TwinController extends AbstractController
{
    #[Route('/twin', name: 'app_twin')]
    public function index(
        CategoryRepository $categoryRepository,
        UserActionRepository $userActionRepo,
    ): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
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

        $allUserActions = $userActionRepo->getAllUserActionsForUser($user);
        usort($allUserActions, fn($a, $b) => $b->getCreatedAt() <=> $a->getCreatedAt());

        $userActionsData = array_map(fn($ua) => [
            'date'       => $ua->getCreatedAt()->format('Y-m-d'),
            'co2'        => (float) $ua->getFinalCo2Saved(),
            'category'   => $ua->getCategory()->getName(),
            'actionName' => $ua->getEcoAction()->getName(),
            'score'      => $ua->getScore(),
        ], $allUserActions);

        return $this->render('twin/index.html.twig', [
            'actionsData'     => $actionsData,
            'userActionsData' => $userActionsData,
        ]);
    }
}
