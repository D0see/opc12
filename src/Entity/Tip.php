<?php

namespace App\Entity;

use App\Repository\TipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipRepository::class)]
class Tip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Month>
     */
    #[ORM\ManyToMany(targetEntity: Month::class, inversedBy: 'tips')]
    private Collection $months;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'tips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->months = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Month>
     */
    public function getMonths(): Collection
    {
        return $this->months;
    }

    public function addMonth(Month $month): static
    {
        if (!$this->months->contains($month)) {
            $this->months->add($month);
        }

        return $this;
    }

    public function removeMonth(Month $month): static
    {
        $this->months->removeElement($month);

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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
}
