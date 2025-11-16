<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        User::factory()->create([
            'name' => 'Abdelrahman ali',
            'email' => 'abdelrahmanali2310@example.com',
            'role' => 'admin',
            'password' => Hash::make('123123123'),
            'linkedin_url' => 'https://www.linkedin.com/in/abdelrahman-ali-aa5a6b1b5/',
            'phone' => '01067794270',
            'avatar_path' => 'https://ui-avatars.com/api/?name=Abdelrahman%20ali&background=6366f1&color=fff&size=128',
        ]);


        $this->call([
            JobPostSeeder::class,
            CommentSeeder::class,
            AnalyticSeeder::class,
            JobCategorySeeder::class,
            ApplicationSeeder::class,
            // NotificationSeeder::class,
        ]);
    }
}
