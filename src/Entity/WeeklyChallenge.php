<?php

namespace App\Entity;

use App\Repository\WeeklyChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeeklyChallengeRepository::class)]
class WeeklyChallenge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    private ?int $targetScore = null;

    #[ORM\Column]
    private ?int $actualScore = null;

    #[ORM\Column(length: 255)]
    private ?string $difficulty = null;

    #[ORM\Column]
    private ?float $difficultyMultiplier = null;

    #[ORM\Column]
    private ?bool $hasWon = null;

    #[ORM\Column]
    private ?bool $isResolved = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTargetScore(): ?int
    {
        return $this->targetScore;
    }

    public function setTargetScore(int $targetScore): static
    {
        $this->targetScore = $targetScore;

        return $this;
    }

    public function getActualScore(): ?int
    {
        return $this->actualScore;
    }

    public function setActualScore(int $actualScore): static
    {
        $this->actualScore = $actualScore;

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

    public function getDifficultyMultiplier(): ?float
    {
        return $this->difficultyMultiplier;
    }

    public function setDifficultyMultiplier(float $difficultyMultiplier): static
    {
        $this->difficultyMultiplier = $difficultyMultiplier;

        return $this;
    }

    public function hasWon(): ?bool
    {
        return $this->hasWon;
    }

    public function setHasWon(bool $hasWon): static
    {
        $this->hasWon = $hasWon;

        return $this;
    }

    public function isResolved(): ?bool
    {
        return $this->isResolved;
    }

    public function setIsResolved(bool $isResolved): static
    {
        $this->isResolved = $isResolved;

        return $this;
    }
}
