<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use App\Models\Booking;
use App\Models\Travel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Initial setup, once the API doesnt recieve
         * another params like the travel_id
         */
        $rows = 26;
        $row_arrangement = 'A B C _ D E F';
        $sits_count = count(explode(' ', $row_arrangement)) * $rows;
        $carbon_now = Carbon::now();
        $database_format = 'Y-m-d H:i:s';

        $aircraft = Aircraft::create([
            'type'              => 'short_range',
            'rows'              => $rows,
            'row_arrangement'   => $row_arrangement,
            'sits_count'        => $sits_count,
        ]);

        $travel = (new Travel)->fill([
            'name'      => 'São Paulo X Rio de Janeiro',
            'leave'     => $carbon_now->format($database_format),
            'arrival'   => $carbon_now->addHour(2)->format($database_format)
        ]);
        $travel->aircraft()->associate($aircraft->id);
        $travel->save();

        $booking = (new Booking);
        $booking->travel()->associate($travel);
        $booking->save();

//        $booking->seats()->create(['row' => 1, 'column' => 'A']);
    }
}
