<?php

use App\Client\WeatherBit\WeatherBitHttpClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class WeatherBitHistoryDailyApi {

    public function __construct(
        private readonly WeatherBitHttpClient $http,
        #[Autowire(env: 'WEATHER_BIT_API_KEY')] private string $apiKey,
    )
    {}

    public function getDailyHistory(
        string $postalCode,
        string $countryCode,
        \DateTime $dateStart,
        \DateTime $dateEnd

    ) {
        return $this->http->get(
            path: '/history/daily?start_date=' . urlencode($dateStart->format('Y-m-d')) .
                '&end_date=' . urlencode($dateEnd->format('Y-m-d')) .
                '&api_key=' . urlencode((string) $this->apiKey) .
                '&postal_code=' . urlencode($postalCode) .
                '&country=' . urlencode($countryCode),
        );
    }
    
}

// https://api.weatherbit.io/v2.0/history/
// daily?start_date=2026-09-05&end_date=2026-09-10&key=API_KEY&postal_code=10001&country=US