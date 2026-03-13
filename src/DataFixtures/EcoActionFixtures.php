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
            ['name' => 'Utiliser le vélo ou le train au lieu de la voiture', 'category' => 'Déplacement', 'inputType' => 'km'],
            ['name' => 'Faire du covoiturage', 'category' => 'Déplacement', 'inputType' => 'km'],
            ['name' => 'Utiliser les transports en commun', 'category' => 'Déplacement', 'inputType' => 'km'],

            ['name' => 'Cuisiner maison plutôt que commander', 'category' => 'Alimentation', 'inputType' => 'none'],
            ['name' => 'Acheter des produits de saison ou locaux', 'category' => 'Alimentation', 'inputType' => 'none'],

            ['name' => 'Réparer un objet électronique', 'category' => 'Consommation', 'inputType' => 'none'],
            ['name' => 'Acheter un produit d\'occasion', 'category' => 'Consommation', 'inputType' => 'none'],

            ['name' => 'Réduire le chauffage de X°C', 'category' => 'Energie', 'inputType' => 'none'],

            ['name' => 'Réduire le streaming vidéo de X heure', 'category' => 'Numérique', 'inputType' => 'none'],
            ['name' => 'Supprimer X mail', 'category' => 'Numérique', 'inputType' => 'none'],

            ['name' => 'Trier ses déchets', 'category' => 'Déchets', 'inputType' => 'none'],
            ['name' => 'Composter des déchets organiques', 'category' => 'Déchets', 'inputType' => 'none'],

            ['name' => 'Planter un arbre', 'category' => 'Engagement écologique', 'inputType' => 'none'],
            ['name' => 'Participer à une action de nettoyage', 'category' => 'Engagement écologique', 'inputType' => 'none'],
        ];

        foreach ($actions as $actionData) {
            $action = new EcoAction();
            $action->setName($actionData['name']);
            $action->setCategory($categoryEntities[$actionData['category']]);
            $action->setInputType($actionData['inputType']);

            $manager->persist($action);
        }

        $manager->flush();
    }
}
