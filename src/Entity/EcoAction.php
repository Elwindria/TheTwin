<?php

namespace App\Entity;

use App\Repository\EcoActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EcoActionRepository::class)]
class EcoAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'ecoActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?category $category = null;

    /**
     * @var Collection<int, EcoActionVariant>
     */
    #[ORM\OneToMany(targetEntity: EcoActionVariant::class, mappedBy: 'ecoAction')]
    private Collection $ecoActionVariants;

    /**
     * @var Collection<int, UserAction>
     */
    #[ORM\OneToMany(targetEntity: UserAction::class, mappedBy: 'ecoAction')]
    private Collection $userActions;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $inputType = null;

    public function __construct()
    {
        $this->ecoActionVariants = new ArrayCollection();
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

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): static
    {
        $this->category = $category;

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
            $ecoActionVariant->setEcoAction($this);
        }

        return $this;
    }

    public function removeEcoActionVariant(EcoActionVariant $ecoActionVariant): static
    {
        if ($this->ecoActionVariants->removeElement($ecoActionVariant)) {
            // set the owning side to null (unless already changed)
            if ($ecoActionVariant->getEcoAction() === $this) {
                $ecoActionVariant->setEcoAction(null);
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
            $userAction->setEcoAction($this);
        }

        return $this;
    }

    public function removeUserAction(UserAction $userAction): static
    {
        if ($this->userActions->removeElement($userAction)) {
            // set the owning side to null (unless already changed)
            if ($userAction->getEcoAction() === $this) {
                $userAction->setEcoAction(null);
            }
        }

        return $this;
    }

    public function getInputType(): ?string
    {
        return $this->inputType;
    }

    public function setInputType(?string $inputType): static
    {
        $this->inputType = $inputType;

        return $this;
    }
}
