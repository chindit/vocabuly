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
            if (Direction::TranslateBoth === $direction && $vocable->getKnowledgeIn() <= $vocable->getKnowledgeOut()) {
                $vocableDirection = Direction::TranslateInbound;
            } else {
	            $vocableDirection = Direction::TranslateOutbound;
            }
            $test->addVocable((new TestVocable())
                ->setVocable($vocable)
                ->setUser($user)
                ->setDirection($vocableDirection)
            );
        }
        $test->setUser($user);
        $test->setLearningLanguage($learningLanguage);
        $test->setVocablesCount(count($vocables));

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        return $test;
    }

    public function checkExercise(TestExercise $exercise)
    {
		$score = 0;

        foreach ($exercise->getVocables() as $vocable) {
            $expected = match ($vocable->getDirection()) {
                Direction::TranslateInbound => $vocable->getVocable()->getTranslation(),
                Direction::TranslateOutbound => $vocable->getVocable()->getOriginal(),
            };

            if (strtolower(trim($expected)) === strtolower(trim($vocable->getAnswer()))) {
                $vocable->setSuccess(true);
				$score++;
                if (Direction::TranslateInbound === $vocable->getDirection() && $vocable->getVocable()->getKnowledgeIn() < 1.0) {
                    $vocable->getVocable()->setKnowledgeIn(min([1.0, $vocable->getVocable()->getKnowledgeIn() + 0.25]));
                } elseif (Direction::TranslateOutbound === $vocable->getDirection() && $vocable->getVocable()->getKnowledgeOut() < 1.0) {
                    $vocable->getVocable()->setKnowledgeOut(min([1.0, $vocable->getVocable()->getKnowledgeOut() + 0.25]));
                }
            } else {
                $vocable->setSuccess(false);
                if (Direction::TranslateInbound === $vocable->getDirection() && $vocable->getVocable()->getKnowledgeIn() > 0) {
                    $vocable->getVocable()->setKnowledgeIn(max([0, $vocable->getVocable()->getKnowledgeIn() - 0.15]));
                } elseif (Direction::TranslateOutbound === $vocable->getDirection() && $vocable->getVocable()->getKnowledgeOut() > 0) {
                    $vocable->getVocable()->setKnowledgeOut(max([0, $vocable->getVocable()->getKnowledgeOut() - 0.15]));
                }
            }
        };

		$exercise->setScore($score/$exercise->getVocablesCount());

        $this->entityManager->flush();
    }
}
