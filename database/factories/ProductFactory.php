<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => fake()->uuid(),
            'title' => fake()->title,
            'description' => fake()->text,
            'description_html' => fake()->text,
            'price' => fake()->randomFloat(),
            'asin' => fake()->randomAscii,
        ];
    }
}
