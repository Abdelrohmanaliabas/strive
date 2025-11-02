<?php

namespace Database\Factories;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //     protected $fillable = ['user_id', 'content'];
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'commentable_id' => JobPost::inRandomOrder()->first()?->id ?? JobPost::factory(),
            'commentable_type' => JobPost::class,
            'content' => $this->faker->sentence(),
        ];
    }
}
