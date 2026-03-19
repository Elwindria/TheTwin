<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

// Ce service gère l'upload et la suppression des photos de profil
class AvatarUploader
{
    public function __construct(
        private string $avatarDirectory,   // le dossier où on stocke les avatars (défini dans services.yaml)
        private SluggerInterface $slugger, // pour nettoyer le nom du fichier (enlever les espaces, accents, etc.)
    ) {}

    // Déplace le fichier uploadé dans le bon dossier et retourne le nouveau nom de fichier
    public function upload(UploadedFile $file): string
    {
        // On prend le nom original du fichier et on le "nettoie" pour éviter les problèmes
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);

        // On ajoute un identifiant unique pour éviter les doublons de noms
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($this->avatarDirectory, $newFilename);

        return $newFilename;
    }

    // Supprime l'ancien avatar du serveur quand l'utilisateur en uploade un nouveau
    public function remove(?string $filename): void
    {
        if (!$filename) {
            return;
        }

        $filepath = $this->avatarDirectory . '/' . $filename;
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
}
