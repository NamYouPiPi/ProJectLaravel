<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\showtimes;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample showtimes - adjust movie_id, hall_id, and times as needed
        showtimes::create([
            'movie_id' => 1, // Replace with actual movie ID
            'hall_id' => 1,  // Replace with actual hall ID
            'start_time' => Carbon::now()->addHours(2), // 2 hours from now
            'end_time' => Carbon::now()->addHours(4),   // 4 hours from now
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => '14:00',
            'price' => 3.00,
        ]);

        showtimes::create([
            'movie_id' => 1, // Another showtime for the same movie
            'hall_id' => 1,
            'start_time' => Carbon::now()->addDays(1)->setTime(18, 0), // Tomorrow 6 PM
            'end_time' => Carbon::now()->addDays(1)->setTime(20, 0),
            'date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'time' => '18:00',
            'price' => 3.00,
        ]);

        // Add more as needed for other movies/halls
        showtimes::create([
            'movie_id' => 2, // Replace with another movie ID
            'hall_id' => 2,  // Replace with another hall ID
            'start_time' => Carbon::now()->addHours(3),
            'end_time' => Carbon::now()->addHours(5),
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => '15:00',
            'price' => 3.00,
        ]);
    }
}
