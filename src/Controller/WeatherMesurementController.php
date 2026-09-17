<?php

namespace App\Controller;

use App\Dto\WeatherMesurement\Mapper\WeatherMesurementMapper;
use App\Entity\User;
use App\Service\PostalCodeService;
use App\Service\WeatherMesurementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/weather-mesurement')]
final class WeatherMesurementController extends AbstractController
{
    public function __construct(
        private readonly WeatherMesurementService $weatherMesurementService,
        private readonly PostalCodeService $postalCodeService,
        private readonly WeatherMesurementMapper $weatherMesurementMapper,
        private readonly Security $security
    )
    {}

    #[Route(name: 'get_my_weather_mesurement', methods: ['GET'])]
    public function getMyWeatherMesurement(): JsonResponse 
    {
        /**
         * @var User
         */
        $user = $this->security->getUser();

        $weatherMesurement = $this->weatherMesurementService->findOrCreateWeatherMesurementWithCaching(
            postalCode: $user->getPostalCode(),
            dateMesure: new \DateTimeImmutable()
        );

        $weatherMesurementDTO = $this->weatherMesurementMapper->WeatherMesurementToOutputDTO($weatherMesurement);

        return new JsonResponse(
            data: $weatherMesurementDTO,
            status: Response::HTTP_OK
        );
    }

    #[Route(path: '/{postalCode}', name: 'get_weather_mesurement', methods: ['GET'])]
    public function getWeatherMesurement(
        string $postalCode
    ): JsonResponse
    {

        $postalCode = $this->postalCodeService->findOrCreatePostalCode($postalCode);

        $weatherMesurement = $this->weatherMesurementService->findOrCreateWeatherMesurementWithCaching(
            postalCode: $postalCode,
            dateMesure: new \DateTimeImmutable()
        );

        $weatherMesurementDTO = $this->weatherMesurementMapper->WeatherMesurementToOutputDTO($weatherMesurement);

        return new JsonResponse(
            data: $weatherMesurementDTO,
            status: Response::HTTP_OK
        );
    }
}
