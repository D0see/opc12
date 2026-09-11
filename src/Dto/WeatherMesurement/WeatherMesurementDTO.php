<?php

namespace App\Dto\WeatherMesurement;

class WeatherMesurementDTO {
    public function __construct(
        float $celsuis,
        string $postalCode
    ){}
}