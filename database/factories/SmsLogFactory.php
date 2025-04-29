<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SmsLog>
 */
class SmsLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phones' => json_encode([$this->faker->phoneNumber]), // Genera un número de teléfono falso
            'message' => $this->faker->sentence, // Genera un mensaje falso
            'status' => $this->faker->randomElement(['success', 'failed']), // Genera un estado aleatorio
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
