<?php

namespace App\Client\GeoApi\Entity\Commune\Dto\Output;

class CommuneDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $code
    ) {
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['nom'], $data['code']) || !is_string($data['nom']) || !is_string($data['code'])) {
            throw new \UnexpectedValueException('Geo API returned an invalid commune response');
        }

        return new self(
            name: $data['nom'],
            code: $data['code']
        );
    }
}
