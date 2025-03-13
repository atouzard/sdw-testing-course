<?php

namespace App\Repository;

use App\Entity\Quest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quest>
 *
 * @method Quest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quest[]    findAll()
 * @method Quest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quest::class);
    }

    public function hasActiveQuest(): bool
    {
        $quest = $this->createQueryBuilder('q')
            ->where('q.finished = false')
            ->orderBy('q.startedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $quest !== null;
    }
}
