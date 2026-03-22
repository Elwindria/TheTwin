<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Repository\AchievementRepository;
use App\Repository\UserAchievementRepository;
use App\Repository\UserActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(UserActionRepository $userActionRepo, AchievementRepository $achievementRepo, UserAchievementRepository $userAchievementRepo): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $now          = new \DateTimeImmutable();
        $currentYear  = (int) $now->format('Y');
        $currentMonth = (int) $now->format('n');

        // dates pour le mois en cours et le mois précédent
        $startThisMonth = new \DateTimeImmutable("$currentYear-$currentMonth-01 00:00:00");
        $startNextMonth = $startThisMonth->modify('first day of next month');

        $lastMonth          = $currentMonth === 1 ? 12 : $currentMonth - 1;
        $lastMonthYear      = $currentMonth === 1 ? $currentYear - 1 : $currentYear;
        $startLastMonth     = new \DateTimeImmutable("$lastMonthYear-$lastMonth-01 00:00:00");

        // dates pour la semaine en cours et la semaine précédente (lundi → dimanche)
        $dayOfWeek      = (int) $now->format('N'); // 1=lundi, 7=dimanche
        $startThisWeek  = $now->modify('-' . ($dayOfWeek - 1) . ' days')->setTime(0, 0, 0);
        $startNextWeek  = $startThisWeek->modify('+7 days');
        $startLastWeek  = $startThisWeek->modify('-7 days');

        // récupération des actions via le repository
        $allActions         = $userActionRepo->getAllUserActionsForUser($user);
        $actionsThisMonth   = $userActionRepo->getAllWeeklyUserActionsForUser($user, $startThisMonth, $startNextMonth);
        $actionsLastMonth   = $userActionRepo->getAllWeeklyUserActionsForUser($user, $startLastMonth, $startThisMonth);
        $actionsThisWeek    = $userActionRepo->getAllWeeklyUserActionsForUser($user, $startThisWeek, $startNextWeek);
        $actionsLastWeek    = $userActionRepo->getAllWeeklyUserActionsForUser($user, $startLastWeek, $startThisWeek);
        $allUsersActions    = $userActionRepo->getAllUserActionsForAllUsers();
        $allUsersLastMonth  = $userActionRepo->getAllWeeklyUserActionsForAllUsers(new \DateTimeImmutable('2000-01-01'), $startThisMonth);

        // calcul des totaux
        $totalCo2     = array_sum(array_map(fn($ua) => (float) $ua->getFinalCo2Saved(), $allActions));
        $twinCo2      = array_sum(array_map(fn($ua) => (float) $ua->getFinalTwinCo2Produced(), $allActions));
        $totalActions = count($allActions);

        $scoreThisWeek    = array_sum(array_map(fn($ua) => $ua->getScore(), $actionsThisWeek));
        $scoreLastWeek    = array_sum(array_map(fn($ua) => $ua->getScore(), $actionsLastWeek));
        $scoreWeekChange  = $scoreThisWeek - $scoreLastWeek;

        $co2ThisMonth     = array_sum(array_map(fn($ua) => (float) $ua->getFinalCo2Saved(), $actionsThisMonth));
        $co2LastMonth     = array_sum(array_map(fn($ua) => (float) $ua->getFinalCo2Saved(), $actionsLastMonth));
        $countThisMonth   = count($actionsThisMonth);
        $countLastMonth   = count($actionsLastMonth);

        // tendances en % (null si pas de données le mois dernier)
        $co2Trend = $co2LastMonth > 0
            ? round(($co2ThisMonth - $co2LastMonth) / $co2LastMonth * 100, 1)
            : null;

        $actionsTrend = $countLastMonth > 0
            ? round(($countThisMonth - $countLastMonth) / $countLastMonth * 100, 1)
            : null;

        // classement global : on groupe les scores par user et on compte combien ont plus que nous
        $scoresByUser = [];
        foreach ($allUsersActions as $ua) {
            $uid = $ua->getUser()->getId();
            $scoresByUser[$uid] = ($scoresByUser[$uid] ?? 0) + $ua->getScore();
        }
        $userScore   = $scoresByUser[$user->getId()] ?? 0;
        $currentRank = count(array_filter($scoresByUser, fn($s) => $s > $userScore)) + 1;

        // même chose pour le mois dernier
        $scoresByUserLastMonth = [];
        foreach ($allUsersLastMonth as $ua) {
            $uid = $ua->getUser()->getId();
            $scoresByUserLastMonth[$uid] = ($scoresByUserLastMonth[$uid] ?? 0) + $ua->getScore();
        }
        $userScoreLastMonth = $scoresByUserLastMonth[$user->getId()] ?? 0;
        $lastMonthRank      = count(array_filter($scoresByUserLastMonth, fn($s) => $s > $userScoreLastMonth)) + 1;

        // positif = on a gagné des places
        $rankChange = $lastMonthRank - $currentRank;

        // CO2 par mois sur les 6 derniers mois (pour le graphique)
        $monthlyCo2 = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate  = $now->modify("-$i months");
            $y          = (int) $monthDate->format('Y');
            $m          = (int) $monthDate->format('n');
            $start      = new \DateTimeImmutable("$y-$m-01 00:00:00");
            $end        = $start->modify('first day of next month');
            $actions    = $userActionRepo->getAllWeeklyUserActionsForUser($user, $start, $end);
            $co2        = array_sum(array_map(fn($ua) => (float) $ua->getFinalCo2Saved(), $actions));
            $monthlyCo2[] = [
                'month' => $monthDate->format('M'),
                'co2'   => round($co2 / 1000, 2), // on affiche en kg dans le graphique
            ];
        }

        // CO2 par catégorie (pour le graphique en barres)
        $co2ByCategory = [];
        foreach ($allActions as $ua) {
            $cat = $ua->getCategory()->getName();
            $co2ByCategory[$cat] = ($co2ByCategory[$cat] ?? 0) + (float) $ua->getFinalCo2Saved();
        }
        $co2ByCategoryData = array_map(
            fn($name, $co2) => ['category' => $name, 'co2' => round($co2 / 1000, 2)],
            array_keys($co2ByCategory),
            array_values($co2ByCategory)
        );

        // toutes les actions avec les champs nécessaires pour le filtre CO2 et l'historique côté React
        $allActionsData = array_map(fn($ua) => [
            'date'       => $ua->getCreatedAt()->format('Y-m-d'),
            'co2'        => (float) $ua->getFinalCo2Saved(),
            'category'   => $ua->getCategory()->getName(),
            'actionName' => $ua->getEcoAction()->getName(),
            'score'      => $ua->getScore(),
        ], $allActions);

        // on trie par date décroissante pour l'historique (les plus récentes en premier)
        usort($allActionsData, fn($a, $b) => strcmp($b['date'], $a['date']));

        // achievements : tous les badges + ceux débloqués par le user
        $allAchievements  = $achievementRepo->findAllActiveOrdered();
        $userAchievements = $userAchievementRepo->findBy(['user' => $user]);
        $unlockedCodes    = array_map(fn($ua) => $ua->getAchievement()->getCode(), $userAchievements);

        // score actuel par type pour calculer le prochain badge
        $categoryTypeMap = [
            'Déplacement' => 'category_deplacement', 'Alimentation' => 'category_alimentation',
            'Consommation' => 'category_consommation', 'Énergie' => 'category_energie',
            'Energie' => 'category_energie', 'Numérique' => 'category_numerique',
            'Numerique' => 'category_numerique', 'Déchets' => 'category_dechets',
            'Dechets' => 'category_dechets', 'Engagement écologique' => 'category_engagement_ecologique',
        ];
        $scoreByType = ['total_score' => $userScore];
        foreach ($allActions as $ua) {
            $t = $categoryTypeMap[$ua->getCategory()->getName()] ?? null;
            if ($t) $scoreByType[$t] = ($scoreByType[$t] ?? 0) + $ua->getScore();
        }

        $nextBadge = null;
        $bestProgress = -1;
        foreach ($allAchievements as $a) {
            if (in_array($a->getCode(), $unlockedCodes) || $a->getType() === 'victory_count') continue;
            $current  = $scoreByType[$a->getType()] ?? 0;
            $progress = $a->getThreshold() > 0 ? $current / $a->getThreshold() : 0;
            if ($progress < 1.0 && $progress > $bestProgress) {
                $bestProgress = $progress;
                $nextBadge = [
                    'name'        => $a->getName(),
                    'type'        => $a->getType(),
                    'imageUrl'    => $a->getImageUrl(),
                    'threshold'   => $a->getThreshold(),
                    'currentValue'=> $current,
                    'progressPct' => round($progress * 100),
                ];
            }
        }

        usort($userAchievements, fn($a, $b) => $b->getAwardedAt() <=> $a->getAwardedAt());
        $recentBadges = array_map(fn($ua) => [
            'code'      => $ua->getAchievement()->getCode(),
            'name'      => $ua->getAchievement()->getName(),
            'type'      => $ua->getAchievement()->getType(),
            'imageUrl'  => $ua->getAchievement()->getImageUrl(),
            'awardedAt' => $ua->getAwardedAt()->format('d M Y'),
        ], array_slice($userAchievements, 0, 3));

        $achievementsData = array_map(fn($a) => [
            'code'        => $a->getCode(),
            'name'        => $a->getName(),
            'description' => $a->getDescription(),
            'type'        => $a->getType(),
            'threshold'   => $a->getThreshold(),
            'imageUrl'    => $a->getImageUrl(),
            'unlocked'    => in_array($a->getCode(), $unlockedCodes),
        ], $allAchievements);

        return $this->render('profile/index.html.twig', [
            'firstName'        => $user->getFirstName(),
            'lastName'         => $user->getLastName(),
            'username'         => $user->getUsername(),
            'totalCo2'         => $totalCo2,
            'twinCo2'          => $twinCo2,
            'scoreThisWeek'    => $scoreThisWeek,
            'scoreWeekChange'  => $scoreWeekChange,
            'totalActions'     => $totalActions,
            'currentRank'      => $currentRank,
            'co2Trend'         => $co2Trend,
            'actionsTrend'     => $actionsTrend,
            'rankChange'       => $rankChange,
            'co2ThisMonth'      => $co2ThisMonth,
            'monthlyGoalCo2'    => $user->getMonthlyGoalCo2(),
            'monthlyCo2'        => $monthlyCo2,
            'co2ByCategoryData' => $co2ByCategoryData,
            'allActionsData'    => $allActionsData,
            'achievementsData'  => $achievementsData,
            'recentBadges'      => $recentBadges,
            'nextBadge'         => $nextBadge,
        ]);
    }

    #[Route('/profile/goal', name: 'app_profile_goal', methods: ['POST'])]
    public function updateGoal(Request $request, EntityManagerInterface $em): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        $goal = isset($data['goal']) ? (int) $data['goal'] : null;

        // on refuse les valeurs négatives ou absurdes (max 1000 kg)
        if ($goal !== null && ($goal < 0 || $goal > 1000000)) {
            return $this->json(['error' => 'Valeur invalide'], 400);
        }

        $user->setMonthlyGoalCo2($goal);
        $em->flush();

        return $this->json(['success' => true, 'goal' => $goal]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si un nouveau mot de passe a été saisi, on le hash et on l'enregistre
            $newPassword = $form->get('newPassword')->getData();
            if ($newPassword) {
                $user->setPassword($hasher->hashPassword($user, $newPassword));
            }

            $em->flush();
            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('app_profile_edit');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
