<?php

namespace App\Service\WeatherMesurement;

use App\Dto\WeatherMesurement\WeatherMesurementDTO;
use WeatherBitHistoryDailyApi;

class WeatherBitWeatherMesurement implements WeatherMesurementInterface {

    public function __construct(
        private readonly WeatherBitHistoryDailyApi $weatherBitHistoryDailyApi
    )
    {}

    public function getWeatherMesurement(string $postalCode): WeatherMesurementDTO {
        $this->weatherBitHistoryDailyApi->getDailyHistory(
            postalCode: $postalCode,
            countryCode: 'FR',
            dateStart: new \DateTime('now'),
            dateEnd: new \DateTime('now')
        );
    }

}