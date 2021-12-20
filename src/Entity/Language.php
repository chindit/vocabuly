<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
    private int $id;

	#[ORM\Column(type: 'string', length: 3)]
    private string $iso;

	#[ORM\Column(type: 'string', length: 250)]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getIso(): string
    {
        return $this->iso;
    }

    public function setIso(string $iso): self
    {
        $this->iso = $iso;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
