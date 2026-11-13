<?php

namespace App\Adapter\PostalCode;

use App\Client\GeoApi\Entity\Commune\Dto\Output\CommuneDTO;
use App\Client\GeoApi\Entity\Commune\GeoApiCommunesApi;

class GeoApiPostalCodeAdapter implements PostalCodeAdapterInterface
{
    public function __construct(
        private readonly GeoApiCommunesApi $geoApiCommunesApi
    ) {
    }

    /**
     * @return CommuneDTO[]
     */
    public function getCommunesByPostalCode(string $postalCode): array
    {
        return $this->geoApiCommunesApi->getCommunesByPostalCode($postalCode);
    }
}
