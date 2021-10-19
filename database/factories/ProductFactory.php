<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'article' => $this->faker->numberBetween(1234, 456789),
            'count' => $this->faker->numberBetween(0, 1400),
            'cost' => $this->faker->numberBetween(100, 14000),
            'description' => $this->faker->text,
            'photo' => null,
            'subcategory_id' => 2
        ];
    }
}
