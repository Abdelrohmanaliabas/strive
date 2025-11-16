<?php

namespace Database\Factories;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Analytic>
 */
class AnalyticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // protected $fillable = ['job_post_id', 'views_count', 'applications_count', 'last_viewed_at'];

            'job_post_id' => JobPost::factory(),
            'views_count' => $this->faker->randomNumber(),
            'applications_count' => $this->faker->randomNumber(),
            'last_viewed_at' => $this->faker->dateTime(),
        ];
    }
}
