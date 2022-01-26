<?php

namespace App\Repository;

use App\Entity\LearningLanguage;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LearningLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LearningLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LearningLanguage[]    findAll()
 * @method LearningLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<LearningLanguage>
 */
class LearningLanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LearningLanguage::class);
    }

    /**
     * @return array<string, mixed>
     */
    public function getStatistics(User $user): array
    {
        return $this->createQueryBuilder('ll')
            ->select('ll.id, ll.language AS language, COUNT(v.id) AS count, ROUND(CAST(AVG(v.knowledgeIn) AS numeric), 2) AS knowledgeIn, ROUND(CAST(AVG(v.knowledgeOut) AS numeric), 2) AS knowledgeOut')
            ->leftJoin('ll.vocables', 'v')
            ->innerJoin('ll.language', 'l')
            ->where('ll.user = :user')
            ->setParameter('user', $user)
            ->groupBy('ll.id')
            ->getQuery()
            ->getScalarResult();
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
