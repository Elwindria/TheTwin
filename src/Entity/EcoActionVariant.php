<?php

namespace App\Entity;

use App\Repository\EcoActionVariantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EcoActionVariantRepository::class)]
class EcoActionVariant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $co2Saved = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $twinCo2Produced = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\ManyToOne(inversedBy: 'ecoActionVariants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ecoAction $ecoAction = null;

    /**
     * @var Collection<int, UserAction>
     */
    #[ORM\OneToMany(targetEntity: UserAction::class, mappedBy: 'ecoActionVariant')]
    private Collection $userActions;

    public function __construct()
    {
        $this->userActions = new ArrayCollection();
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

    public function getCo2Saved(): ?string
    {
        return $this->co2Saved;
    }

    public function setCo2Saved(string $co2Saved): static
    {
        $this->co2Saved = $co2Saved;

        return $this;
    }

    public function getTwinCo2Produced(): ?string
    {
        return $this->twinCo2Produced;
    }

    public function setTwinCo2Produced(string $twinCo2Produced): static
    {
        $this->twinCo2Produced = $twinCo2Produced;

        return $this;
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

    public function getEcoAction(): ?ecoAction
    {
        return $this->ecoAction;
    }

    public function setEcoAction(?ecoAction $ecoAction): static
    {
        $this->ecoAction = $ecoAction;

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
            $userAction->setEcoActionVariant($this);
        }

        return $this;
    }

    public function removeUserAction(UserAction $userAction): static
    {
        if ($this->userActions->removeElement($userAction)) {
            // set the owning side to null (unless already changed)
            if ($userAction->getEcoActionVariant() === $this) {
                $userAction->setEcoActionVariant(null);
            }
        }

        return $this;
    }
}
