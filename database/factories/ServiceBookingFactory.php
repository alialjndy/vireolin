<?php

namespace Database\Factories;

use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceBooking>
 */
class ServiceBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => ServiceType::inRandomOrder()->first()->id,
            'user_id'    => User::inRandomOrder()->first()->id,
            'message'    => $this->faker->sentence(),
            'status'     => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
