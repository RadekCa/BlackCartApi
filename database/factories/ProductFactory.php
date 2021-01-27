<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;
    protected array $currency = ['CAD','USD','EU'];
    protected array $size = ['X','L','M','XXL'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'price' => rand(100,200),
            'currency' => Arr::random($this->currency),
            'inventory' => rand(0,100),
            'size' => Arr::random($this->size),
            'color' => $this->faker->colorName,
            'weight' => rand(10,400),
            'store_id' => rand(101,102),
            'active' => 1
        ];
    }
}
