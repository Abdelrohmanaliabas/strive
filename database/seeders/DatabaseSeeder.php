<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->count(2)->state(['role' => 'admin'])->create();
        User::factory()->count(5)->state(['role' => 'employer'])->create();
        User::factory()->count(10)->state(['role' => 'candidate'])->create();


        $this->call([
            JobPostSeeder::class,
            CommentSeeder::class,
            AnalyticSeeder::class,
            JobCategorySeeder::class,
            ApplicationSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
