<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    /**
     * @var string[]
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string')]
    private string $password;

    /**
     * @var Collection<int, Vocable> $vocables
     */
    #[ORM\OneToMany(targetEntity: Vocable::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $vocables;

    /**
     * @var Collection<int, LearningLanguage> $learningLanguages
     */
    #[ORM\OneToMany(targetEntity: LearningLanguage::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $learningLanguages;

	#[ORM\OneToMany(targetEntity: TestExercise::class, mappedBy: 'user', orphanRemoval: true)]
    private $testExercises;

    public function __construct()
    {
        $this->vocables = new ArrayCollection();
        $this->learningLanguages = new ArrayCollection();
        $this->testExercises = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $vocable->setUser($this);
        }

        return $this;
    }

    public function removeVocable(Vocable $vocable): self
    {
        $this->vocables->removeElement($vocable);

        return $this;
    }

    /**
     * @return Collection<int, LearningLanguage>
     */
    public function getLearningLanguages(): Collection
    {
        return $this->learningLanguages;
    }

    public function addLearningLanguage(LearningLanguage $learningSession): self
    {
        if (!$this->learningLanguages->contains($learningSession)) {
            $this->learningLanguages[] = $learningSession;
            $learningSession->setUser($this);
        }

        return $this;
    }

    public function removeLearningLanguage(LearningLanguage $learningSession): self
    {
        $this->learningLanguages->removeElement($learningSession);

        return $this;
    }

    /**
     * @return Collection|TestExercise[]
     */
    public function getTestExercises(): Collection
    {
        return $this->testExercises;
    }

    public function addTestExercise(TestExercise $testExercise): self
    {
        if (!$this->testExercises->contains($testExercise)) {
            $this->testExercises[] = $testExercise;
            $testExercise->setUser($this);
        }

        return $this;
    }

    public function removeTestExercise(TestExercise $testExercise): self
    {
        $this->testExercises->removeElement($testExercise);

        return $this;
    }
}
