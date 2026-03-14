<?php

namespace App\DataFixtures;

use App\Entity\EcoAction;
use App\Entity\EcoActionVariant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EcoActionVariantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ecoActionRepository = $manager->getRepository(EcoAction::class);

        $actionsVariants = [
            'Utiliser le vélo ou le train au lieu de la voiture' => [
                [
                    'name' => 'Vélo',
                    'co2_saved' => 170.00,
                    'twin_co2_produced' => 170.00,
                    'score' => 17,
                ],
                [
                    'name' => 'Train',
                    'co2_saved' => 135.00,
                    'twin_co2_produced' => 170.00,
                    'score' => 14,
                ],
            ],
            'Faire du covoiturage' => [
                [
                    'name' => '2 passagers',
                    'co2_saved' => 85.00,
                    'twin_co2_produced' => 170.00,
                    'score' => 9,
                ],
                [
                    'name' => '3 passagers',
                    'co2_saved' => 113.33,
                    'twin_co2_produced' => 170.00,
                    'score' => 11,
                ],
                [
                    'name' => '4 passagers',
                    'co2_saved' => 127.50,
                    'twin_co2_produced' => 170.00,
                    'score' => 13,
                ],
            ],
            'Utiliser les transports en commun' => [
                [
                    'name' => 'Tram / bus électrique',
                    'co2_saved' => 140.00,
                    'twin_co2_produced' => 170.00,
                    'score' => 14,
                ],
            ],
            'Cuisiner maison plutôt que commander' => [
                [
                    'name' => 'Repas maison',
                    'co2_saved' => 850.00,
                    'twin_co2_produced' => 850.00,
                    'score' => 85,
                ],
            ],
            'Acheter des produits de saison ou locaux' => [
                [
                    'name' => 'Achat local / de saison',
                    'co2_saved' => 300.00,
                    'twin_co2_produced' => 300.00,
                    'score' => 30,
                ],
            ],
            'Réparer un objet électronique' => [
                [
                    'name' => 'Téléphone',
                    'co2_saved' => 80000.00,
                    'twin_co2_produced' => 80000.00,
                    'score' => 8000,
                ],
                [
                    'name' => 'Ordinateur portable',
                    'co2_saved' => 190000.00,
                    'twin_co2_produced' => 190000.00,
                    'score' => 19000,
                ],
                [
                    'name' => 'Tablette',
                    'co2_saved' => 90000.00,
                    'twin_co2_produced' => 90000.00,
                    'score' => 9000,
                ],
                [
                    'name' => 'Casque audio',
                    'co2_saved' => 14000.00,
                    'twin_co2_produced' => 14000.00,
                    'score' => 1400,
                ],
                [
                    'name' => 'Micro-ondes',
                    'co2_saved' => 25000.00,
                    'twin_co2_produced' => 25000.00,
                    'score' => 2500,
                ],
            ],
            'Acheter un produit d\'occasion' => [
                [
                    'name' => 'Téléphone',
                    'co2_saved' => 80000.00,
                    'twin_co2_produced' => 80000.00,
                    'score' => 8000,
                ],
                [
                    'name' => 'Ordinateur portable',
                    'co2_saved' => 190000.00,
                    'twin_co2_produced' => 190000.00,
                    'score' => 19000,
                ],
                [
                    'name' => 'Tablette',
                    'co2_saved' => 90000.00,
                    'twin_co2_produced' => 90000.00,
                    'score' => 9000,
                ],
                [
                    'name' => 'Casque audio',
                    'co2_saved' => 14000.00,
                    'twin_co2_produced' => 14000.00,
                    'score' => 1400,
                ],
                [
                    'name' => 'Micro-ondes',
                    'co2_saved' => 25000.00,
                    'twin_co2_produced' => 25000.00,
                    'score' => 2500,
                ],
                [
                    'name' => 'Vêtement',
                    'co2_saved' => 6430.00,
                    'twin_co2_produced' => 6430.00,
                    'score' => 643,
                ],
                [
                    'name' => 'Chaussures',
                    'co2_saved' => 14000.00,
                    'twin_co2_produced' => 14000.00,
                    'score' => 1400,
                ],
                [
                    'name' => 'Livre',
                    'co2_saved' => 2000.00,
                    'twin_co2_produced' => 2000.00,
                    'score' => 200,
                ],
                [
                    'name' => 'Cafetière',
                    'co2_saved' => 10000.00,
                    'twin_co2_produced' => 10000.00,
                    'score' => 1000,
                ],
            ],
            'Réduire le chauffage de X°C' => [
                [
                    'name' => '-1°C',
                    'co2_saved' => 210.00,
                    'twin_co2_produced' => 210.00,
                    'score' => 21,
                ],
                [
                    'name' => '-2°C',
                    'co2_saved' => 420.00,
                    'twin_co2_produced' => 420.00,
                    'score' => 42,
                ],
                [
                    'name' => '-3°C',
                    'co2_saved' => 630.00,
                    'twin_co2_produced' => 630.00,
                    'score' => 63,
                ],
                [
                    'name' => '-4°C',
                    'co2_saved' => 840.00,
                    'twin_co2_produced' => 840.00,
                    'score' => 84,
                ],
                [
                    'name' => '-5°C',
                    'co2_saved' => 1050.00,
                    'twin_co2_produced' => 1050.00,
                    'score' => 105,
                ],
            ],
            'Réduire le streaming vidéo de X heure' => [
                [
                    'name' => '1 heure',
                    'co2_saved' => 55.00,
                    'twin_co2_produced' => 55.00,
                    'score' => 6,
                ],
                [
                    'name' => '2 heures',
                    'co2_saved' => 110.00,
                    'twin_co2_produced' => 110.00,
                    'score' => 11,
                ],
                [
                    'name' => '3 heures',
                    'co2_saved' => 165.00,
                    'twin_co2_produced' => 165.00,
                    'score' => 17,
                ],
                [
                    'name' => '4 heures',
                    'co2_saved' => 220.00,
                    'twin_co2_produced' => 220.00,
                    'score' => 22,
                ],
                [
                    'name' => '5 heures',
                    'co2_saved' => 275.00,
                    'twin_co2_produced' => 275.00,
                    'score' => 28,
                ],
            ],
            'Supprimer X mails' => [
                [
                    'name' => '10 mails',
                    'co2_saved' => 1.00,
                    'twin_co2_produced' => 1.00,
                    'score' => 1,
                ],
                [
                    'name' => '100 mails',
                    'co2_saved' => 10.00,
                    'twin_co2_produced' => 10.00,
                    'score' => 1,
                ],
                [
                    'name' => '200 mails',
                    'co2_saved' => 20.00,
                    'twin_co2_produced' => 20.00,
                    'score' => 2,
                ],
                [
                    'name' => '500 mails',
                    'co2_saved' => 50.00,
                    'twin_co2_produced' => 50.00,
                    'score' => 5,
                ],
                [
                    'name' => '1000 mails',
                    'co2_saved' => 100.00,
                    'twin_co2_produced' => 100.00,
                    'score' => 10,
                ],
            ],
            'Trier ses déchets' => [
                [
                    'name' => 'tri',
                    'co2_saved' => 500.00,
                    'twin_co2_produced' => 500.00,
                    'score' => 50,
                ],
            ],
            'Composter des déchets organiques' => [
                [
                    'name' => '100 g',
                    'co2_saved' => 50.00,
                    'twin_co2_produced' => 50.00,
                    'score' => 5,
                ],
                [
                    'name' => '300 g',
                    'co2_saved' => 150.00,
                    'twin_co2_produced' => 150.00,
                    'score' => 15,
                ],
                [
                    'name' => '500 g',
                    'co2_saved' => 250.00,
                    'twin_co2_produced' => 250.00,
                    'score' => 25,
                ],
            ],
            'Planter un arbre' => [
                [
                    'name' => '1 arbre',
                    'co2_saved' => 10000.00,
                    'twin_co2_produced' => 10000.00,
                    'score' => 1000,
                ],
            ],
            'Participer à une action de nettoyage' => [
                [
                    'name' => '1 heure',
                    'co2_saved' => 1000.00,
                    'twin_co2_produced' => 1000.00,
                    'score' => 100,
                ],
            ],
        ];

        foreach ($actionsVariants as $actionName => $variants) {
            $action = $ecoActionRepository->findOneBy([
                'name' => $actionName,
            ]);

            if (!$action) {
                continue;
            }

            foreach ($variants as $variantData) {
                $variant = new EcoActionVariant();
                $variant->setName($variantData['name']);
                $variant->setEcoAction($action);
                $variant->setCo2Saved((string) $variantData['co2_saved']);
                $variant->setTwinCo2Produced((string) $variantData['twin_co2_produced']);
                $variant->setScore($variantData['score']);

                $manager->persist($variant);
            }
        }

        $manager->flush();
    }
}