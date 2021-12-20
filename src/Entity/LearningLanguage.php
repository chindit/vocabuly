<?php

namespace App\Entity;

use App\Repository\LearningLanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:LearningLanguageRepository::class)]
class LearningLanguage
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
    private int $id;

	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'learningSessions')]
	#[ORM\JoinColumn(nullable: false)]
    private User $user;

	#[ORM\ManyToOne(targetEntity: Language::class)]
	#[ORM\JoinColumn(nullable: false)]
    private Language $language;

	#[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    /**
     * @var Collection<int, Vocable> $vocables
     */
	#[ORM\OneToMany(targetEntity: Vocable::class, mappedBy: 'session')]
    private Collection $vocables;

	public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->vocables = new ArrayCollection();
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

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function setLanguage(Language $language): self
    {
        $this->language = $language;

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

    /**
     * @return Collection<int, Vocable>
     */
    public function getVocables(): Collection
    {
        return $this->vocables;
    }

    public function addVocable(Vocable $vocable): self
    {
        if (!$this->vocables->contains($vocable)) {
            $this->vocables[] = $vocable;
            $vocable->setLearningLanguage($this);
        }

        return $this;
    }

    public function removeVocable(Vocable $vocable): self
    {
        $this->vocables->removeElement($vocable);

        return $this;
    }
}
