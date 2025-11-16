<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPost>
 */
class JobPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // protected $fillable = [
            //     'employer_id',
            //     'category_id',
            //     'title',
            //     'description',
            //     'responsibilities',
            //     'skills',
            //     'qualifications',
            //     'salary_range',
            //     'benefits',
            //     'location',
            //     'work_type',
            //     'technologies',
            //     'application_deadline',
            //     'logo',
            //     'status',];

            'employer_id' => User::where('role', 'employer')->inRandomOrder()->first()->id,
            'category_id' => \App\Models\JobCategory::factory(),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'responsibilities' => $this->faker->text(),
            'skills' => $this->faker->text(),
            'requirements' => $this->faker->text(),
            'salary_range' => $this->faker->randomNumber(),
            'benefits' => $this->faker->text(),
            'work_type' => $this->faker->randomElement(['remote', 'onsite', 'hybrid']),
            'location' => $this->faker->text(),
            'technologies' => $this->faker->text(),
            'application_deadline' => $this->faker->dateTime(),
            'logo' => $this->faker->url(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),


        ];
    }
}
