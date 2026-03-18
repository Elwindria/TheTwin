<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Repository\UserActionRepository;
use App\Service\AvatarUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(UserActionRepository $userActionRepo): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $avatarUrl = $user->getAvatarFilename()
            ? '/uploads/avatars/' . $user->getAvatarFilename()
            : null;

        $now          = new \DateTimeImmutable();
        $currentYear  = (int) $now->format('Y');
        $currentMonth = (int) $now->format('n');

        // dates pour le mois en cours et le mois précédent
        $startThisMonth = new \DateTimeImmutable("$currentYear-$currentMonth-01 00:00:00");
        $startNextMonth = $startThisMonth->modify('first day of next month');

        $lastMonth          = $currentMonth === 1 ? 12 : $currentMonth - 1;
        $lastMonthYear      = $currentMonth === 1 ? $currentYear - 1 : $currentYear;
        $startLastMonth     = new \DateTimeImmutable("$lastMonthYear-$lastMonth-01 00:00:00");

        // récupération des actions via le repository
        $allActions         = $userActionRepo->getAllUserActionsForUser($user);
        $actionsThisMonth   = $userActionRepo->getAllWeeklyUserActionsForUser($user, $startThisMonth, $startNextMonth);
        $actionsLastMonth   = $userActionRepo->getAllWeeklyUserActionsForUser($user, $startLastMonth, $startThisMonth);
        $allUsersActions    = $userActionRepo->getAllUserActionsForAllUsers();
        $allUsersLastMonth  = $userActionRepo->getAllWeeklyUserActionsForAllUsers(new \DateTimeImmutable('2000-01-01'), $startThisMonth);

        // calcul des totaux
        $totalCo2     = array_sum(array_map(fn($ua) => (float) $ua->getFinalCo2Saved(), $allActions));
        $totalActions = count($allActions);

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

        // toutes les actions avec les champs nécessaires pour le filtre par période côté React
        $allActionsData = array_map(fn($ua) => [
            'date'     => $ua->getCreatedAt()->format('Y-m-d'),
            'co2'      => (float) $ua->getFinalCo2Saved(),
            'category' => $ua->getCategory()->getName(),
        ], $allActions);

        return $this->render('profile/index.html.twig', [
            'firstName'        => $user->getFirstName(),
            'lastName'         => $user->getLastName(),
            'username'         => $user->getUsername(),
            'avatarUrl'        => $avatarUrl,
            'totalCo2'         => $totalCo2,
            'totalActions'     => $totalActions,
            'currentRank'      => $currentRank,
            'co2Trend'         => $co2Trend,
            'actionsTrend'     => $actionsTrend,
            'rankChange'       => $rankChange,
            'monthlyCo2'        => $monthlyCo2,
            'co2ByCategoryData' => $co2ByCategoryData,
            'allActionsData'    => $allActionsData,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, AvatarUploader $avatarUploader): Response
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

            // Si l'utilisateur a uploadé une nouvelle photo de profil
            $avatarFile = $form->get('avatarFile')->getData();
            if ($avatarFile) {
                // On supprime l'ancien avatar pour ne pas garder des fichiers inutiles
                $avatarUploader->remove($user->getAvatarFilename());

                // On sauvegarde le nouveau fichier et on met à jour l'entité
                $newFilename = $avatarUploader->upload($avatarFile);
                $user->setAvatarFilename($newFilename);
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
