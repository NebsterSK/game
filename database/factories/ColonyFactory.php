<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Colony>
 */
class ColonyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->colorName(),
            'params' => [
                'population' => 10,
                'builders' => 0,
                'engineers' => 0,
                'scientists' => 0,
                'power' => 10,
            ],
            'user_id' => User::factory(),
        ];
    }
}
