<?php

namespace App\Adapter\WeatherMesurement;

use App\Dto\WeatherMesurement\WeatherMesurementDTO;
use App\Adapter\WeatherMesurement\WeatherMesurerInterface;
use App\Client\WeatherBit\Entity\HistoryDaily\WeatherBitCurrentWeatherApi;

class WeatherBitWeatherMesurer implements WeatherMesurerInterface {

    public function __construct(
        private readonly WeatherBitCurrentWeatherApi $weatherBitCurrentWeatherApi
    )
    {}

    public function getWeatherMesurement(string $postalCode): WeatherMesurementDTO {

        $today = new \DateTimeImmutable('now');

        $historyDailyOutputDTO = $this->weatherBitCurrentWeatherApi->getCurrentWeather(
            postalCode: $postalCode,
            countryCode: 'FR'
        );

        return new WeatherMesurementDTO(
            temperature: $historyDailyOutputDTO->temp,
            date: $today,
            postalCode: $postalCode
        );
    }

}