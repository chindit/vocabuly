<?php

namespace App\Entity;

use App\Repository\LearningSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LearningSessionRepository::class)
 */
class LearningSession
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="learningSessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Vocable::class, mappedBy="session")
     */
    private $vocables;

	public function __construct()
                     	{
                     		$this->createdAt = new \DateTimeImmutable();
                       $this->vocables = new ArrayCollection();
                     	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Vocable[]
     */
    public function getVocables(): Collection
    {
        return $this->vocables;
    }

    public function addVocable(Vocable $vocable): self
    {
        if (!$this->vocables->contains($vocable)) {
            $this->vocables[] = $vocable;
            $vocable->setSession($this);
        }

        return $this;
    }

    public function removeVocable(Vocable $vocable): self
    {
        if ($this->vocables->removeElement($vocable)) {
            // set the owning side to null (unless already changed)
            if ($vocable->getSession() === $this) {
                $vocable->setSession(null);
            }
        }

        return $this;
    }
}
