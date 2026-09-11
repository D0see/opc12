<?php

namespace App\Adapter\WeatherMesurement;

use App\Dto\WeatherMesurement\WeatherMesurementDTO;

interface WeatherMesurerInterface {
    public function getWeatherMesurement(string $postalCode): WeatherMesurementDTO;
}