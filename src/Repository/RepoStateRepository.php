<?php

namespace App\Repository;

use App\Entity\RepoState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepoState|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepoState|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepoState[]    findAll()
 * @method RepoState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepoStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepoState::class);
    }

    // /**
    //  * @return RepoState[] Returns an array of RepoState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RepoState
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
