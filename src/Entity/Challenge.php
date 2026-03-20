<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChallengeRepository::class)]
class Challenge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'challenges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, EcoAction>
     */
    #[ORM\ManyToMany(targetEntity: EcoAction::class)]
    #[ORM\JoinTable(name: 'challenge_eco_action')]
    private Collection $ecoActions;

    /**
     * @var Collection<int, EcoActionVariant>
     */
    #[ORM\ManyToMany(targetEntity: EcoActionVariant::class)]
    #[ORM\JoinTable(name: 'challenge_eco_action_variant')]
    private Collection $ecoActionVariants;

    public function __construct()
    {
        $this->ecoActions = new ArrayCollection();
        $this->ecoActionVariants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
        }

        return $this;
    }

    public function removeEcoAction(EcoAction $ecoAction): static
    {
        $this->ecoActions->removeElement($ecoAction);

        return $this;
    }

    /**
     * @return Collection<int, EcoActionVariant>
     */
    public function getEcoActionVariants(): Collection
    {
        return $this->ecoActionVariants;
    }

    public function addEcoActionVariant(EcoActionVariant $ecoActionVariant): static
    {
        if (!$this->ecoActionVariants->contains($ecoActionVariant)) {
            $this->ecoActionVariants->add($ecoActionVariant);
        }

        return $this;
    }

    public function removeEcoActionVariant(EcoActionVariant $ecoActionVariant): static
    {
        $this->ecoActionVariants->removeElement($ecoActionVariant);

        return $this;
    }
}
