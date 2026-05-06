<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    protected $model = Barang::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'originalPrice' => $this->faker->numberBetween(1000, 100000),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'category' => $this->faker->word(),
        ];
    }
}
