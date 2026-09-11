<?php

namespace App\Service\WeatherMesurement;

use App\Dto\WeatherMesurement\WeatherMesurementDTO;

interface WeatherMesurementInterface {
    public function getWeatherMesurement(string $postalCode): WeatherMesurementDTO;
}