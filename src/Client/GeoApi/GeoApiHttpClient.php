<?php

namespace App\Client\GeoApi;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GeoApiHttpClient
{
    private const API_BASE_URL = 'https://geo.api.gouv.fr';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function get(string $path, array $query = []): ResponseInterface
    {
        return $this->httpClient->request(
            'GET',
            rtrim(self::API_BASE_URL, '/') . '/' . ltrim($path, '/'),
            ['query' => $query]
        );
    }
}
