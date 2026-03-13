<?php

namespace App\Entity;

use App\Repository\UserActionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserActionRepository::class)]
class UserAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $finalCo2Saved = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $finalTwinCo2Produced = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\ManyToOne(inversedBy: 'userActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'userActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ecoAction $ecoAction = null;

    #[ORM\ManyToOne(inversedBy: 'userActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EcoActionVariant $ecoActionVariant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getFinalCo2Saved(): ?string
    {
        return $this->finalCo2Saved;
    }

    public function setFinalCo2Saved(string $finalCo2Saved): static
    {
        $this->finalCo2Saved = $finalCo2Saved;

        return $this;
    }

    public function getFinalTwinCo2Produced(): ?string
    {
        return $this->finalTwinCo2Produced;
    }

    public function setFinalTwinCo2Produced(string $finalTwinCo2Produced): static
    {
        $this->finalTwinCo2Produced = $finalTwinCo2Produced;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getEcoAction(): ?ecoAction
    {
        return $this->ecoAction;
    }

    public function setEcoAction(?ecoAction $ecoAction): static
    {
        $this->ecoAction = $ecoAction;

        return $this;
    }

    public function getEcoActionVariant(): ?EcoActionVariant
    {
        return $this->ecoActionVariant;
    }

    public function setEcoActionVariant(?EcoActionVariant $ecoActionVariant): static
    {
        $this->ecoActionVariant = $ecoActionVariant;

        return $this;
    }
}
