<?php

namespace App\Repository;

use App\Entity\LearningLanguage;
use App\Entity\User;
use App\Entity\Vocable;
use App\Enum\Direction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
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

    /** @return array<int, Vocable> */
    public function getVocableInRandomOrder(
        User $user,
        int $count,
        LearningLanguage $language,
        Direction $direction,
        bool $unknown
    ): array {
        $query = $this->createQueryBuilder('v')
            ->where('v.user = :user')
            ->andWhere('v.learningLanguage = :language');

        if ($unknown) {
            $query->andWhere(match ($direction) {
                Direction::TranslateInbound => 'v.knowledgeIn < 1.0',
                Direction::TranslateOutbound => 'v.knowledgeOut < 1.0',
                Direction::TranslateBoth => 'v.knowledgeIn < 1.0 OR v.knowledgeOut < 1.0',
            });
        }

        /** @var list<Vocable> $result */
        $result = $query
            ->setParameter('user', $user)
            ->setParameter('language', $language)
            ->setMaxResults($count)
            ->orderBy('RANDOM()')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /** @return array<int, Vocable> */
    public function getPage(User $user, int $page): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.user = :user')
            ->setParameter('user', $user)
            ->setFirstResult(($page - 1) * 25)
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();
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
