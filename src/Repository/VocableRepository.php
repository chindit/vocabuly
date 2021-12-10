<?php

namespace App\Repository;

use App\Entity\Vocable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vocable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vocable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vocable[]    findAll()
 * @method Vocable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VocableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vocable::class);
    }

    // /**
    //  * @return Vocable[] Returns an array of Vocable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vocable
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
