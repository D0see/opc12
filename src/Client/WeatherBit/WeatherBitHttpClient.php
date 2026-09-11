<?php
 
namespace App\Client\WeatherBit;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
 
class WeatherBitHttpClient
{
 
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire(env: 'WEATHER_BIT_API_KEY')] private string $apiKey,
        #[Autowire(env: 'WEATHER_BIT_API_BASE_URL')] private string $apiBaseUrl,

    ) {
    }
 
    public function get(string $path, array $query = [], array $headers = []): ResponseInterface
    {
        return $this->request('GET', $path, [
            'query' => $query,
            'headers' => $headers,
        ]);
    }
 
    public function post(string $path, array|object $json = [], array $headers = []): ResponseInterface
    {   
        
        return $this->request('POST', $path, [
            'json' => $json,
            'headers' => $headers,
        ]);
    }
 
    public function put(string $path, array|object $json = [], array $headers = []): ResponseInterface
    {
        return $this->request('PUT', $path, [
            'json' => $json,
            'headers' => $headers,
        ]);
    }
 
    public function delete(string $path, array $headers = []): ResponseInterface
    {
        return $this->request('DELETE', $path, [
            'headers' => $headers,
        ]);
    }
 
    public function request(string $method, string $path, array $options = []): ResponseInterface
    {
        $this->validateConfiguration();
 
        $headers = $this->buildHeaders($options['headers'] ?? []);
 
        return $this->httpClient->request(
            $method,
            $this->buildUrl($path),
            array_merge($options, [
                'headers' => $headers,
            ])
        );
    }

 
    private function buildHeaders(array $extra): array
    {
        $headers = [
            'Authorization' => $this->resolveAuthorization(),
            'Accept' => 'application/json',
        ];
 
        return array_merge($headers, $extra);
    }
 
    private function resolveAuthorization(): string
    {
        if (trim($this->apiKey) === '') {
            throw new \RuntimeException('WEATHER_BIT_API_KEY is empty');
        }
 
        return $this->apiKey;
    }
 
    private function buildUrl(string $path): string
    {
        return rtrim($this->apiBaseUrl, '/') . '/' . ltrim($path, '/');
    }
 
    private function validateConfiguration(): void
    {
        if (trim($this->apiBaseUrl) === '') {
            throw new \RuntimeException('WEATHER_BIT_API_BASE_URL is empty');
        }
    }
}