<?php

namespace App\Entity;

use App\Repository\TestVocableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestVocableRepository::class)
 */
class TestVocable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Vocable::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Vocable $vocable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $answer = '';

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $success = false;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $direction = 0;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

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

    public function getVocable(): Vocable
    {
        return $this->vocable;
    }

    public function setVocable(Vocable $vocable): self
    {
        $this->vocable = $vocable;

        return $this;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function getDirection(): int
    {
        return $this->direction;
    }

    public function setDirection(int $direction): self
    {
        $this->direction = $direction;

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
}
