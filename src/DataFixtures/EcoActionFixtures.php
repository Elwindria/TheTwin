<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\EcoAction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EcoActionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Déplacement',
            'Alimentation',
            'Consommation',
            'Energie',
            'Numérique',
            'Déchets',
            'Engagement écologique',
        ];

        $categoryEntities = [];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $categoryEntities[$categoryName] = $category;
        }

        $actions = [
            ['name' => 'Utiliser le vélo ou le train au lieu de la voiture', 'category' => 'Déplacement'],
            ['name' => 'Faire du covoiturage', 'category' => 'Déplacement'],
            ['name' => 'Utiliser les transports en commun', 'category' => 'Déplacement'],

            ['name' => 'Cuisiner maison plutôt que commander', 'category' => 'Alimentation'],
            ['name' => 'Acheter des produits de saison ou locaux', 'category' => 'Alimentation'],

            ['name' => 'Réparer un objet électronique', 'category' => 'Consommation'],
            ['name' => 'Acheter un produit d\'occasion', 'category' => 'Consommation'],

            ['name' => 'Réduire le chauffage de X°C', 'category' => 'Energie'],

            ['name' => 'Réduire le streaming vidéo de X heure', 'category' => 'Numérique'],
            ['name' => 'Supprimer X mail', 'category' => 'Numérique'],

            ['name' => 'Trier ses déchets', 'category' => 'Déchets'],
            ['name' => 'Composter des déchets organiques', 'category' => 'Déchets'],

            ['name' => 'Planter un arbre', 'category' => 'Engagement écologique'],
            ['name' => 'Participer à une action de nettoyage', 'category' => 'Engagement écologique'],
        ];

        foreach ($actions as $actionData) {
            $action = new EcoAction();
            $action->setName($actionData['name']);
            $action->setCategory($categoryEntities[$actionData['category']]);

            $manager->persist($action);
        }

        $manager->flush();
    }
}
