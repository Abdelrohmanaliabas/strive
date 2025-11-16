<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // protected $fillable = ['candidate_id', 'job_post_id', 'resume', 'name', 'email', 'phone', 'status'];

            'candidate_id' => \App\Models\User::where('role', 'candidate')->inRandomOrder()->first()->id,
            'job_post_id' => \App\Models\JobPost::factory(),
            'resume' => $this->faker->url(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected', 'cancelled']),
        ];
    }
}
