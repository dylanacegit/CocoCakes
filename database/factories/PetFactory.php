<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->firstName(),
            'type' => fake()->randomElement(['Dog', 'Cat', 'Rabbit']),
            'breed' => fake()->words(2, true),
            'age' => fake()->numberBetween(1, 15),
        ];
    }
}
