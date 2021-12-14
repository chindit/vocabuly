<?php

namespace App\Entity;

use App\Repository\VocableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VocableRepository::class)
 */
class Vocable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $original;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $translation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vocables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=LearningLanguage::class, inversedBy="vocables")
     */
    private $session;

    /**
     * @ORM\Column(type="float")
     */
    private $knowledgeIn = 0.0;

    /**
     * @ORM\Column(type="float")
     */
    private $knowledgeOut = 0.0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginal(): ?string
    {
        return $this->original;
    }

    public function setOriginal(string $original): self
    {
        $this->original = $original;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
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

    public function getSession(): ?LearningLanguage
    {
        return $this->session;
    }

    public function setSession(?LearningLanguage $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getKnowledgeIn(): ?float
    {
        return $this->knowledgeIn;
    }

    public function setKnowledgeIn(float $knowledgeIn): self
    {
        $this->knowledgeIn = $knowledgeIn;

        return $this;
    }

    public function getKnowledgeOut(): ?float
    {
        return $this->knowledgeOut;
    }

    public function setKnowledgeOut(float $knowledgeOut): self
    {
        $this->knowledgeOut = $knowledgeOut;

        return $this;
    }
}
