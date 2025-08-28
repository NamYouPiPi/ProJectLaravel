<?php

namespace Database\Seeders;

use App\Models\Hall_cinema;
use App\Models\Seat_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seats;
use App\Models\HallCinema;
use App\Models\SeatType;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the first hall (adjust as needed)
        $hall = Hall_cinema::first();
        if (!$hall) {
            $this->command->error('No hall found. Please create a hall first.');
            return;
        }

        // Get seat types (adjust as needed)
        $regularSeatType = Seat_type::where('name', 'Regular')->first();
        $vipSeatType = Seat_type::where('name', 'VIP')->first();
        $premiumSeatType = Seat_type::where('name', 'Premium')->first();

        // Default to first seat type if specific types don't exist
        if (!$regularSeatType) {
            $regularSeatType = Seat_type::first();
        }

        // Seat layout configuration
        $rows = ['L', 'K', 'J', 'I', 'H', 'G', 'F', 'E', 'D', 'C', 'B', 'A']; // Back to front
        $seatsPerRow = 12; // 12 seats per row (1-12)

        $seats = [];

        foreach ($rows as $rowLetter) {
            for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++) {
                // Determine seat type based on row and position
                $seatType = $regularSeatType; // Default

                // VIP seats in front rows (A-D) and center positions (4-9)
                if (in_array($rowLetter, ['A', 'B', 'C', 'D']) && $seatNumber >= 4 && $seatNumber <= 9) {
                    $seatType = $vipSeatType ?: $regularSeatType;
                }

                // Premium seats in very front (A-B) and premium positions (5-8)
                if (in_array($rowLetter, ['A', 'B']) && $seatNumber >= 5 && $seatNumber <= 8) {
                    $seatType = $premiumSeatType ?: $vipSeatType ?: $regularSeatType;
                }

                $seats[] = [
                    'hall_id' => $hall->id,
                    'seat_type_id' => $seatType->id,
                    'seat_row' => $rowLetter,
                    'seat_number' => (string)$seatNumber,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert seats in chunks to avoid memory issues
        foreach (array_chunk($seats, 100) as $chunk) {
            Seats::insert($chunk);
        }

        $this->command->info('Seats table seeded successfully!');
        $this->command->info('Created ' . count($seats) . ' seats for hall: ' . $hall->name);
        $this->command->info('Layout: ' . count($rows) . ' rows x ' . $seatsPerRow . ' seats per row');
    }
}
