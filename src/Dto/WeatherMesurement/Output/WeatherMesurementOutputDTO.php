<?php

namespace App\Dto\WeatherMesurement\Output;

class WeatherMesurementOutputDTO {
    public function __construct(
        public readonly float $temperature,
        public readonly string $date,
        public readonly string $postalCode
    ){}
}