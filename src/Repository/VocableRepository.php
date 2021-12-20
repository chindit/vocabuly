<?php

namespace App\Repository;

use App\Entity\LearningLanguage;
use App\Entity\User;
use App\Entity\Vocable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vocable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vocable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vocable[]    findAll()
 * @method Vocable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<Vocable>
 */
class VocableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vocable::class);
    }

    /**
     * @return array<string, mixed>
     */
    public function getStatistics(User $user, LearningLanguage $language): array
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v.id) AS count, AVG(v.knowledgeIn) AS knowledgeIn, AVG(v.knowledgeOut) AS knowledgeOut')
            ->where('v.user = :user')
            ->andWhere('v.learningLanguage = :language')
            ->setParameter('user', $user)
            ->setParameter('language', $language)
            ->getQuery()
            ->getScalarResult();
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
