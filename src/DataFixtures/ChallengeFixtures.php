<?php

namespace App\DataFixtures;

use App\Entity\Challenge;
use App\Repository\CategoryRepository;
use App\Repository\EcoActionRepository;
use App\Repository\EcoActionVariantRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EcoActionRepository $ecoActionRepository,
        private EcoActionVariantRepository $ecoActionVariantRepository,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $challenges = [
            [
                'title' => 'Semaine Verte',
                'description' => 'Utilisez les transports en commun chaque jour',
                'difficulty' => 'facile',
                'category' => 'Déplacement',
                'actions' => ['Utiliser les transports en commun'],
            ],
            [
                'title' => 'Champion du Vélo',
                'description' => 'Parcourez 50km à vélo cette semaine',
                'difficulty' => 'moyen',
                'category' => 'Déplacement',
                'actions' => ['Utiliser le vélo ou le train au lieu de la voiture'],
            ],
            [
                'title' => 'Covoiturage Solidaire',
                'description' => 'Faites du covoiturage 3 fois cette semaine',
                'difficulty' => 'moyen',
                'category' => 'Déplacement',
                'actions' => ['Faire du covoiturage'],
            ],
            [
                'title' => 'Chef Maison',
                'description' => 'Cuisinez tous vos repas à la maison',
                'difficulty' => 'moyen',
                'category' => 'Alimentation',
                'actions' => ['Cuisiner maison plutôt que commander'],
            ],
            [
                'title' => 'Marché Local',
                'description' => 'Achetez des produits locaux et de saison',
                'difficulty' => 'facile',
                'category' => 'Alimentation',
                'actions' => ['Acheter des produits de saison ou locaux'],
            ],
            [
                'title' => 'Consommateur Responsable',
                'description' => 'Achetez uniquement en occasion cette semaine',
                'difficulty' => 'difficile',
                'category' => 'Consommation',
                'actions' => ['Acheter un produit d\'occasion'],
            ],
            [
                'title' => 'Réparateur',
                'description' => 'Réparez un appareil électronique cette semaine',
                'difficulty' => 'moyen',
                'category' => 'Consommation',
                'actions' => ['Réparer un objet électronique'],
            ],
            [
                'title' => 'Économie d\'Énergie',
                'description' => 'Réduisez le chauffage de 2°C',
                'difficulty' => 'facile',
                'category' => 'Energie',
                'actions' => ['Réduire le chauffage de X°C'],
            ],
            [
                'title' => 'Minimaliste Digital',
                'description' => 'Réduisez le streaming vidéo et nettoyez votre email',
                'difficulty' => 'facile',
                'category' => 'Numérique',
                'actions' => ['Réduire le streaming vidéo de X heure', 'Supprimer X mails'],
            ],
            [
                'title' => 'Tri Parfait',
                'description' => 'Triez tous vos déchets et compostez',
                'difficulty' => 'facile',
                'category' => 'Déchets',
                'actions' => ['Trier ses déchets', 'Composter des déchets organiques'],
            ],
            [
                'title' => 'Gardien de la Terre',
                'description' => 'Plantez un arbre et participez à un nettoyage',
                'difficulty' => 'moyen',
                'category' => 'Engagement écologique',
                'actions' => ['Planter un arbre', 'Participer à une action de nettoyage'],
            ],
        ];

        foreach ($challenges as $challengeData) {
            $category = $this->categoryRepository->findOneBy(['name' => $challengeData['category']]);
            
            if (!$category) {
                continue;
            }

            $challenge = new Challenge();
            $challenge->setTitle($challengeData['title']);
            $challenge->setDescription($challengeData['description']);
            $challenge->setDifficulty($challengeData['difficulty']);
            $challenge->setCategory($category);

            // Add eco actions to the challenge
            foreach ($challengeData['actions'] as $actionName) {
                $ecoAction = $this->ecoActionRepository->findOneBy(['name' => $actionName]);
                
                if ($ecoAction) {
                    $challenge->addEcoAction($ecoAction);
                    
                    // Add the default variant (first one) if available
                    $variants = $ecoAction->getEcoActionVariants();
                    if ($variants->count() > 0) {
                        $challenge->addEcoActionVariant($variants->first());
                    }
                }
            }

            $manager->persist($challenge);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EcoActionFixtures::class,
        ];
    }
}
