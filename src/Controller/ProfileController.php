<?php

namespace App\Controller;

use App\Form\ProfileFormType;
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
