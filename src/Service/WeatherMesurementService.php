<?php

namespace App\Service;

use App\Adapter\WeatherMesurement\WeatherMesurerInterface;
use App\Entity\WeatherMesurement;
use App\Repository\WeatherMesurementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class WeatherMesurementService {
    public function __construct(
        private readonly WeatherMesurerInterface $weatherMesurer,
        private readonly PostalCodeService $postalCodeService,
        private readonly EntityManagerInterface $entityManager,
        private readonly WeatherMesurementRepository $weatherMesurementRepository,
        private readonly TagAwareCacheInterface $cache
    ){}

    public function findOrCreateWeatherMesurement(
        string $postalCode
    ): WeatherMesurement {

        $today = new \DateTimeImmutable();

        $idCache = $postalCode . '-' . $today->format('Y-m-d');

        $postalCode = $this->postalCodeService->findOrCreatePostalCode($postalCode);

        $weatherMesurement = $this->cache->get($idCache, function (ItemInterface $item) use ($postalCode, $today) {
            $item->tag("weatherMesurement");
            $weatherMesurement = $this->weatherMesurementRepository->findOneBy(
                [
                    'postalCode' => $postalCode,
                    'mesuredAt' => $today
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
        });

        return $weatherMesurement;
    }
}