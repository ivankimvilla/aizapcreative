<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'service' => 'Product Ad',
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'company' => $this->faker->company(),
            'message' => $this->faker->sentence(),
            'starts_at' => now()->addDays(2)->setTime(10, 0),
            'timezone' => 'UTC',
            'timezone_label' => 'UTC',
            'meeting_link' => 'https://meet.google.com/new',
            'status' => 'pending',
            'is_read' => false,
        ];
    }
}
