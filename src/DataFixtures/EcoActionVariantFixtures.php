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

        $action = $ecoActionRepository->findOneBy([
            'name' => 'Utiliser le vélo ou le train au lieu de la voiture'
        ]);

        if (!$action) {
            return;
        }

        $variants = [
            [
                'name' => 'Vélo',
                'co2_saved' => 170,
                'twin_co2_produced' => 170,
                'score' => 17
            ],
            [
                'name' => 'Train',
                'co2_saved' => 135,
                'twin_co2_produced' => 170,
                'score' => 14
            ]
        ];

        foreach ($variants as $variantData) {
            $variant = new EcoActionVariant();
            $variant->setName($variantData['name']);
            $variant->setEcoAction($action);
            $variant->setCo2Saved($variantData['co2_saved']);
            $variant->setTwinCo2Produced($variantData['twin_co2_produced']);
            $variant->setScore($variantData['score']);

            $manager->persist($variant);
        }

        $manager->flush();
    }
}
