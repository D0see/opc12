<?php

namespace App\Entity;

use App\Repository\PostalCodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostalCodeRepository::class)]
class PostalCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $code = null;

    /**
     * @var Collection<int, WeatherMesurement>
     */
    #[ORM\OneToMany(targetEntity: WeatherMesurement::class, mappedBy: 'postalCode')]
    private Collection $weatherMesurements;

    public function __construct()
    {
        $this->weatherMesurements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, WeatherMesurement>
     */
    public function getWeatherMesurements(): Collection
    {
        return $this->weatherMesurements;
    }

    public function addWeatherMesurement(WeatherMesurement $weatherMesurement): static
    {
        if (!$this->weatherMesurements->contains($weatherMesurement)) {
            $this->weatherMesurements->add($weatherMesurement);
            $weatherMesurement->setPostalCode($this);
        }

        return $this;
    }

    public function removeWeatherMesurement(WeatherMesurement $weatherMesurement): static
    {
        if ($this->weatherMesurements->removeElement($weatherMesurement)) {
            // set the owning side to null (unless already changed)
            if ($weatherMesurement->getPostalCode() === $this) {
                $weatherMesurement->setPostalCode(null);
            }
        }

        return $this;
    }
}
