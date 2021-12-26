<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\LearningLanguage;
use App\Entity\TestExercise;
use App\Entity\TestVocable;
use App\Entity\User;
use App\Entity\Vocable;
use App\Enum\Direction;
use App\Repository\VocableRepository;
use Doctrine\ORM\EntityManagerInterface;

class VocableService
{
    public function __construct(public EntityManagerInterface $entityManager)
    {
    }

    public function createTest(
        User $user,
        Direction $direction,
        int $vocablesCount,
        bool $includeKnown,
        LearningLanguage $learningLanguage,
        VocableRepository $repository
    ): ?TestExercise {
        $vocables = $repository->getVocableInRandomOrder($user, $vocablesCount, $learningLanguage, $direction, $includeKnown);

        if (empty($vocables)) {
            return null;
        }

        $test = new TestExercise();
        /** @var Vocable $vocable */
        foreach ($vocables as $vocable) {
            if (Direction::TranslateBoth === $direction && $vocable->getKnowledgeIn() < $vocable->getKnowledgeOut()) {
                $direction = Direction::TranslateInbound;
            } else {
                $direction = Direction::TranslateOutbound;
            }
            $test->addVocable((new TestVocable())
                ->setVocable($vocable)
                ->setUser($user)
                ->setDirection($direction)
            );
        }
        $test->setUser($user);
        $test->setLearningLanguage($learningLanguage);
        $test->setVocablesCount(count($vocables));

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        return $test;
    }
}
