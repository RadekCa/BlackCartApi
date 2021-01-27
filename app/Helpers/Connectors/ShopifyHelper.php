<?php

namespace App\Helpers\Connectors;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

/**
 * Class ShopifyHelper
 *
 * @package App\Helpers
 */
class ShopifyHelper
{
    /**
     * @var string|mixed
     */
    protected string $api_key;
    protected string $password;
    protected string $host;
    protected string $secret;
    protected string $version;

    protected string $url;
    protected Client $client;

    /**
     * ShopifyHelper constructor.
     */
    public function __construct()
    {
        $this->api_key = env('SHOPIFY_API_KEY');
        $this->password = env('SHOPIFY_API_PASSWORD');
        $this->secret = env('SHOPIFY_API_SHARED_SECRET');
        $this->host = env('SHOPIFY_API_HOST');
        $this->version = env('SHOPIFY_API_VERSION');

        $this->url = "https://{$this->api_key}:{$this->password}@{$this->host}/admin/api/{$this->version}/";
        $this->client = new Client();
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $payload
     *
     * @return array
     *
     * @throws GuzzleException
     */
    protected function request(string $method, string $uri, array $payload): array
    {
        $response = $this->client->request(
            $method,
            "{$this->url}{$uri}",
            [
                'form_params' => $payload
            ]
        );

        try {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return [];
        }
    }

    /**
     * @param array $payload
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function products(array $payload = []): array
    {
        return $this->request('GET', 'products.json', $payload);
    }
}
