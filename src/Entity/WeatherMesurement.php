<?php

namespace App\Entity;

use App\Repository\WeatherMesurementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherMesurementRepository::class)]
class WeatherMesurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $temperature = null;

    #[ORM\ManyToOne(inversedBy: 'weatherMesurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalCode $postalCode = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $mesuredAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getPostalCode(): ?PostalCode
    {
        return $this->postalCode;
    }

    public function setPostalCode(?PostalCode $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getMesuredAt(): ?\DateTimeImmutable
    {
        return $this->mesuredAt;
    }

    public function setMesuredAt(\DateTimeImmutable $mesuredAt): static
    {
        $this->mesuredAt = $mesuredAt;

        return $this;
    }
}
