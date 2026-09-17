<?php

namespace App\Service;

use App\Adapter\WeatherMesurement\WeatherMesurerInterface;
use App\Entity\PostalCode;
use App\Entity\WeatherMesurement;
use App\Repository\WeatherMesurementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class WeatherMesurementService {
    public function __construct(
        private readonly WeatherMesurerInterface $weatherMesurer,
        private readonly EntityManagerInterface $entityManager,
        private readonly WeatherMesurementRepository $weatherMesurementRepository,
        private readonly TagAwareCacheInterface $cache
    ){}

    public function findOrCreateWeatherMesurementWithCaching(
        PostalCode $postalCode,
        \Datetime $dateMesure
    ): WeatherMesurement {

        $today = new \DateTimeImmutable();

        $idCache = $postalCode->getCode() . '-' . $today->format('Y-m-d');

        $weatherMesurement = $this->cache->get($idCache, function (ItemInterface $item) use ($postalCode, $dateMesure) {
            $item->tag("weatherMesurement");
            
            return $this->_findOrCreateWeatherMesurement(
                postalCode: $postalCode,
                dateMesure: $dateMesure
            );

        });

        return $weatherMesurement;
    }

    private function _findOrCreateWeatherMesurement(
        PostalCode $postalCode,
        \Datetime $dateMesure
    ): WeatherMesurement {

        $weatherMesurement = $this->weatherMesurementRepository->findOneBy(
                [
                    'postalCode' => $postalCode,
                    'mesuredAt' => $dateMesure
                ]
        );

        if ($weatherMesurement !== null) {
            return $weatherMesurement;
        }

        $weatherMesurementDTO = $this->weatherMesurer->getWeatherMesurement($postalCode->getCode());

        $weatherMesurement = (new WeatherMesurement())
        ->setTemperature($weatherMesurementDTO->temperature)
        ->setMesuredAt($weatherMesurementDTO->date)
        ->setPostalCode($postalCode);

        $this->entityManager->persist($weatherMesurement);

        $this->entityManager->flush();

        return $weatherMesurement;
    }
}