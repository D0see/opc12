<?php

namespace App\Controller;

use App\Dto\WeatherMesurement\Mapper\WeatherMesurementMapper;
use App\Entity\User;
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

        $postalCode = $user->getPostalCode()->getCode();

        $weatherMesurement = $this->weatherMesurementService->findOrCreateWeatherMesurement($postalCode);

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
        if ($postalCode === "") {
            /**
             * @var User
             */
            $user = $this->security->getUser();
            $postalCode = $user->getPostalCode()->getCode();
        }

        $weatherMesurement = $this->weatherMesurementService->findOrCreateWeatherMesurement($postalCode);

        $weatherMesurementDTO = $this->weatherMesurementMapper->WeatherMesurementToOutputDTO($weatherMesurement);

        return new JsonResponse(
            data: $weatherMesurementDTO,
            status: Response::HTTP_OK
        );
    }
}
