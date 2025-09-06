<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->unique()->words(2, true), // exemplo: "Project Alpha"
            'description' => $this->faker->sentence(8),              // descrição aleatória
            'start'       => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end'         => $this->faker->dateTimeBetween('now', '+2 months'),
            'status'      => $this->faker->randomElement(['active', 'disabled']),
        ];
    }
}
