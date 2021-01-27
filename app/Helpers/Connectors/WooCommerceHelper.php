<?php

namespace App\Helpers\Connectors;

use Automattic\WooCommerce\Client;

/**
 * Class WooCommerceHelper
 *
 * @package App\Helpers\Connectors
 */
class WooCommerceHelper
{
    /**
     * @var string|mixed
     */
    protected string $api_key;
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
        $this->api_key = env('WOOCOMMERCE_API_KEY');
        $this->secret = env('WOOCOMMERCE_API_SHARED_SECRET');
        $this->host = env('WOOCOMMERCE_API_HOST');
        $this->version = env('WOOCOMMERCE_API_VERSION');

        $this->client = new Client("https://{$this->host}/",
          $this->api_key, $this->secret,
          ['wp_api' => true, 'version' => 'wc/v3']
        );
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
        return $this->client->get('products', $payload);
    }
}
