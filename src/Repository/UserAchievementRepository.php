<?php

namespace App\Repository;

use App\Entity\UserAchievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAchievement>
 */
class UserAchievementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAchievement::class);
    }

    public function findAllWithUserAndAchievement(): array
    {
        return $this->createQueryBuilder('ua')
            ->leftJoin('ua.user', 'u')
            ->addSelect('u')
            ->leftJoin('ua.achievement', 'a')
            ->addSelect('a')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
