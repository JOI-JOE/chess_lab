<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'thumbnail' => 'https://www.hollywoodreporter.com/wp-content/uploads/2024/02/art-soul-of-dune.jpg?w=200&h=200&crop=1',
            'author' => fake()->name(),
            'publisher' => fake()->name(),
            'publication' => fake()->dateTime(),
            'price' => fake()->numberBetween(50, 100),
            'quantity' => 30,
            'category_id' => rand(1, 5)
        ];
    }
}
