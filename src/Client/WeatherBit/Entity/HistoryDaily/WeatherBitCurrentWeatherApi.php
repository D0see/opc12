<?php

namespace App\Client\WeatherBit\Entity\HistoryDaily;

use App\Client\WeatherBit\Entity\HistoryDaily\Dto\Output\CurrentWeatherDTO;
use App\Client\WeatherBit\WeatherBitHttpClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class WeatherBitCurrentWeatherApi {

    public function __construct(
        private readonly WeatherBitHttpClient $http,
        #[Autowire(env: 'WEATHER_BIT_API_KEY')] private string $apiKey,
    )
    {}

    public function getCurrentWeather(
        string $postalCode,
        string $countryCode

    ): CurrentWeatherDTO {
        $data =  $this->http->get(
            path: '/current' .
                '?key=' . urlencode((string) $this->apiKey) .
                '&postal_code=' . urlencode($postalCode) .
                '&country=' . urlencode($countryCode)
        )->toArray()['data'][0];

        return CurrentWeatherDTO::fromArray($data);
    }
    
}

// https://api.weatherbit.io/v2.0/history/
// daily?start_date=2026-09-05&end_date=2026-09-10&key=API_KEY&postal_code=10001&country=US