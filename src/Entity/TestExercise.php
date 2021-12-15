<?php

namespace App\Entity;

use App\Repository\TestExerciseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestExerciseRepository::class)
 */
class TestExercise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="testExercises")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity=LearningLanguage::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private LearningLanguage $learningLanguage;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $vocablesCount = 0;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private float $score = 0.0;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLearningLanguage(): LearningLanguage
    {
        return $this->learningLanguage;
    }

    public function setLearningLanguage(LearningLanguage $learningLanguage): self
    {
        $this->learningLanguage = $learningLanguage;

        return $this;
    }

    public function getVocablesCount(): int
    {
        return $this->vocablesCount;
    }

    public function setVocablesCount(int $vocablesCount): self
    {
        $this->vocablesCount = $vocablesCount;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }
}
