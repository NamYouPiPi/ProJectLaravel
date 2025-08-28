<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hall_cinema;

class HallCinemaSeeder extends Seeder
{
    public function run()
    {
        Hall_cinema::create([
            'cinema_name' => 'Main Hall',
            'Hall_location_id' => 1, // Change this if you have a different location id
            'total_seats' => 120,
            'status' => 'active',
            'hall_type' => 'imax'
        ]);
    }
}
