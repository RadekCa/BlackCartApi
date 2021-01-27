<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    /**
     * Failure test in case of using wrong parameter
     *
     * @return void
     */
    public function testBadParamStoreId(): void
    {
        $response = $this->json('GET', '/stores/string/products', []);
        $json = $this->json_decode($response);

        $this->assertEquals($json['success'], false);
    }

    /**
     * OK test in case of using valid parameter for storeID ['required', 'numeric']
     *
     * @return void
     */
    public function testOkParamStoreId(): void
    {
        $response = $this->json('GET', '/stores/2/products', []);
        $json = $this->json_decode($response);

        $this->assertEquals($json['success'], true);
    }

    /**
     * OK test for checking the number of records and json values
     *
     * @return void
     */
    public function testOkProductsCount(): void
    {
        $response = $this->json('GET', '/stores/1/products', []);
        $json = $this->json_decode($response);

        $countDB = Product::where('store_id', 1)->count();
        $countJson = count($json['data']);

        $this->assertEquals($countJson, $countDB);
    }

    /**
     * @param $response
     * @return array
     *
     * Helper for json
     */
    public function json_decode($response): array
    {
        try {
            return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR | JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return [];
        }
    }
}
