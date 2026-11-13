<?php

namespace App\Adapter\PostalCode;

use App\Client\GeoApi\Entity\Commune\Dto\Output\CommuneDTO;

interface PostalCodeAdapterInterface
{
    /**
     * @return list<CommuneDTO>
     */
    public function getCommunesByPostalCode(string $postalCode): array;
}
