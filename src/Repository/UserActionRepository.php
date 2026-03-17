<?php

namespace App\Repository;

use App\Entity\UserAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeImmutable;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<UserAction>
 */
class UserActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAction::class);
    }

    public function getTotalTwinCo2ForUserForThisWeek(
        User $user,
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) : float {
            return (float) $this->createQueryBuilder('ua')
                ->select('COALESCE(SUM(ua.finalTwinCo2Produced), 0)')
                ->where('ua.user = :user')
                ->andWhere('ua.createdAt >= :start')
                ->andWhere('ua.createdAt < :end')
                ->setParameter('user', $user)
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->getQuery()
                ->getSingleScalarResult();
    }

    public function getTotalTwinCo2ForAllUsersForThisWeek(
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) : float {
            return (float) $this->createQueryBuilder('ua')
                ->select('COALESCE(SUM(ua.finalTwinCo2Produced), 0)')
                ->where('ua.createdAt >= :start')
                ->andWhere('ua.createdAt < :end')
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->getQuery()
                ->getSingleScalarResult();
    }
}
