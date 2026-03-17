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

    public function getAllWeeklyUserActionsForUser(
        User $user,
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) : array {
        return $this->createQueryBuilder('ua')
            ->where('ua.user = :user')
            ->andWhere('ua.createdAt >= :start')
            ->andWhere('ua.createdAt < :end')
            ->setParameter('user', $user)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }

    public function getAllUserActionsForUser(
        User $user,
    ) : array {
        return $this->createQueryBuilder('ua')
            ->where('ua.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function getAllWeeklyUserActionsForAllUsers(
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) : array {
        return $this->createQueryBuilder('ua')
            ->where('ua.createdAt >= :start')
            ->andWhere('ua.createdAt < :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }

    public function getAllUserActionsForAllUsers(
    ) : array {
        return $this->createQueryBuilder('ua')
            ->getQuery()
            ->getResult();
    }

    public function findAllActionWithUserAndCategory(): array
    {
        return $this->createQueryBuilder('ua')
            ->leftJoin('ua.user', 'u')
            ->addSelect('u')
            ->leftJoin('ua.category', 'c')
            ->addSelect('c')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
