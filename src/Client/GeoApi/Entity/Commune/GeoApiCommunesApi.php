<?php

namespace App\Client\GeoApi\Entity\Commune;

use App\Client\GeoApi\GeoApiHttpClient;
use App\Client\GeoApi\Entity\Commune\Dto\Output\CommuneDTO;

class GeoApiCommunesApi
{
    public function __construct(
        private readonly GeoApiHttpClient $http
    ) {
    }

    /**
     * @return list<CommuneDTO>
     */
    public function getCommunesByPostalCode(string $postalCode): array
    {
        $communes = $this->http->get('/communes', [
            'codePostal' => $postalCode,
        ])->toArray();

        return array_map(
            static fn (array $commune): CommuneDTO => CommuneDTO::fromArray($commune),
            $communes
        );
    }
}
