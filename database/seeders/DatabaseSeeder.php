<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\Rental;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $cars = [
            [
                'size' => 'Small',
                'capacity' => 5,
                'cost' => 5000
            ],
            [
                'size' => 'Medium',
                'capacity' => 10,
                'cost' => 8000
            ],
            [
                'size' => 'Large',
                'capacity' => 15,
                'cost' => 12000
            ],
        ];
        DB::table('rentals')->insert($cars);
    }
    
}
