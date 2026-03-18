<?php

namespace App\Controller;

use App\Repository\UserActionRepository;
use App\Service\EcoMetricsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CollectiveController extends AbstractController
{
    #[Route('/collective', name: 'app_collective')]
    public function index(
        UserActionRepository $userActionRepository,
        EcoMetricsService $ecoMetricsService
    ): Response
    {
        // Données globales de tous les utilisateurs via le service de Pierre
        $summary = $ecoMetricsService->getSummaryForAllUsers();

        $activeUsersCount = $userActionRepository->createQueryBuilder('ua')
            ->select('COUNT(DISTINCT ua.user)')
            ->where('ua.isAvailable = true')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;

        //Les  10 dernières actions de tous les utilisateurs
        $recentActions = $userActionRepository->createQueryBuilder('ua')
            ->select('ua', 'u', 'ea', 'c')
            ->join('ua.user', 'u')
            ->join('ua.ecoAction', 'ea')
            ->join('ua.category', 'c')
            ->where('ua.isAvailable = true')
            ->orderBy('ua.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $recentActionsData = array_map(function ($action) {
            return [
                'username'   => $action->getUser()->getUsername(),
                'action'     => $action->getEcoAction()->getName(),
                'category'   => $action->getCategory()->getName(),
                'score'      => $action->getScore(),
                'co2Saved'   => $action->getFinalCo2Saved(),
                'createdAt'  => $action->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $recentActions);

        return $this->render('collective/index.html.twig', [
            'totalScore'        => $summary['totalScore'],
            'totalCo2Saved'     => $summary['totalCo2Saved'],
            'totalTwinCo2'      => $summary['totalTwinCo2Produced'],
            'activeUsersCount'  => (int) $activeUsersCount,
            'recentActions'     => $recentActionsData,
        ]);
    }
}
