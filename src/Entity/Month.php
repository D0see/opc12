<?php

namespace App\Entity;

use App\Repository\MonthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonthRepository::class)]
class Month
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Tip>
     */
    #[ORM\ManyToMany(targetEntity: Tip::class, mappedBy: 'months')]
    private Collection $tips;

    #[ORM\Column]
    private ?int $num = null;

    public function __construct()
    {
        $this->tips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Tip>
     */
    public function getTips(): Collection
    {
        return $this->tips;
    }

    public function addTip(Tip $tip): static
    {
        if (!$this->tips->contains($tip)) {
            $this->tips->add($tip);
            $tip->addMonth($this);
        }

        return $this;
    }

    public function removeTip(Tip $tip): static
    {
        if ($this->tips->removeElement($tip)) {
            $tip->removeMonth($this);
        }

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

        return $this;
    }
}
