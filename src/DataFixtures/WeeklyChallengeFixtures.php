<?php

namespace App\DataFixtures;

use App\Entity\WeeklyChallenge;
use App\ValueObject\WeekRange;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WeeklyChallengeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $week = WeekRange::current();

        $weeklyChallenge = new WeeklyChallenge();
        $weeklyChallenge->setStartAt($week->getStart());
        $weeklyChallenge->setEndAt($week->getEnd());
        $weeklyChallenge->setTargetScore(10000);
        $weeklyChallenge->setActualScore(0);
        $weeklyChallenge->setDifficulty('normal');
        $weeklyChallenge->setDifficultyMultiplier('1.00');
        $weeklyChallenge->setHasWon(false);
        $weeklyChallenge->setIsResolved(false);

        $manager->persist($weeklyChallenge);
        $manager->flush();
    }
}