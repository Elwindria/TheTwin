<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, EcoAction>
     */
    #[ORM\OneToMany(targetEntity: EcoAction::class, mappedBy: 'category')]
    private Collection $ecoActions;

    /**
     * @var Collection<int, UserAction>
     */
    #[ORM\OneToMany(targetEntity: UserAction::class, mappedBy: 'category')]
    private Collection $userActions;

    /**
     * @var Collection<int, Challenge>
     */
    #[ORM\OneToMany(targetEntity: Challenge::class, mappedBy: 'category')]
    private Collection $challenges;

    public function __construct()
    {
        $this->ecoActions = new ArrayCollection();
        $this->userActions = new ArrayCollection();
        $this->challenges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, EcoAction>
     */
    public function getEcoActions(): Collection
    {
        return $this->ecoActions;
    }

    public function addEcoAction(EcoAction $ecoAction): static
    {
        if (!$this->ecoActions->contains($ecoAction)) {
            $this->ecoActions->add($ecoAction);
            $ecoAction->setCategory($this);
        }

        return $this;
    }

    public function removeEcoAction(EcoAction $ecoAction): static
    {
        if ($this->ecoActions->removeElement($ecoAction)) {
            // set the owning side to null (unless already changed)
            if ($ecoAction->getCategory() === $this) {
                $ecoAction->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserAction>
     */
    public function getUserActions(): Collection
    {
        return $this->userActions;
    }

    public function addUserAction(UserAction $userAction): static
    {
        if (!$this->userActions->contains($userAction)) {
            $this->userActions->add($userAction);
            $userAction->setCategory($this);
        }

        return $this;
    }

    public function removeUserAction(UserAction $userAction): static
    {
        if ($this->userActions->removeElement($userAction)) {
            // set the owning side to null (unless already changed)
            if ($userAction->getCategory() === $this) {
                $userAction->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): static
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges->add($challenge);
            $challenge->setCategory($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): static
    {
        if ($this->challenges->removeElement($challenge)) {
            // set the owning side to null (unless already changed)
            if ($challenge->getCategory() === $this) {
                $challenge->setCategory(null);
            }
        }

        return $this;
    }
}
