<?php

namespace App\Dto\WeatherMesurement\Mapper;

use App\Dto\WeatherMesurement\Output\WeatherMesurementOutputDTO;
use App\Entity\WeatherMesurement;

class WeatherMesurementMapper {
    
    public function WeatherMesurementToOutputDTO(WeatherMesurement $weatherMesurement): WeatherMesurementOutputDTO
    {
        return new WeatherMesurementOutputDTO(
            temperature: $weatherMesurement->getTemperature(),
            date: $weatherMesurement->getMesuredAt()->format('Y-m-d'),
            postalCode: $weatherMesurement->getPostalCode()->getCode()
        );
    }
}