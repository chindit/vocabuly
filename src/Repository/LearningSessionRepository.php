<?php

namespace App\Repository;

use App\Entity\LearningSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LearningSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method LearningSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method LearningSession[]    findAll()
 * @method LearningSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LearningSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LearningSession::class);
    }

    // /**
    //  * @return LearningSession[] Returns an array of LearningSession objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LearningSession
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
