<?php

namespace App\Repository;

use App\Entity\WeeklyChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeImmutable;

/**
 * @extends ServiceEntityRepository<WeeklyChallenge>
 */
class WeeklyChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeeklyChallenge::class);
    }

    public function findOneByPeriod(
        \DateTimeImmutable $start,
        \DateTimeImmutable $end
    ): ?WeeklyChallenge {
        return $this->createQueryBuilder('wc')
            ->where('wc.startAt = :start')
            ->andWhere('wc.endAt = :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getOneOrNullResult();
    }
}