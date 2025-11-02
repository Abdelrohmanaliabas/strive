<?php

namespace Database\Seeders;

use App\Models\Analytic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnalyticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Analytic::factory(10)->create();
    }
}
