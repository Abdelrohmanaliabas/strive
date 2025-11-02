<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //    protected $fillable = ['user_id', 'type', 'message', 'is_read'];

            'user_id' => \App\Models\User::factory(),
            'type' => $this->faker->randomElement(['success', 'info', 'warning', 'error']),
            'message' => $this->faker->text(),
            'is_read' => $this->faker->boolean(),

        ];
    }
}
