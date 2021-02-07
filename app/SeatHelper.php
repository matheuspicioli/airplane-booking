<?php

namespace App;

use App\Models\Booking;
use App\Models\Seat;

class SeatHelper
{
    public static function showAllSeats(): array
    {
        return Seat::all()->map(fn($seat) => $seat->column.$seat->row)->toArray();
    }

    public static function createSeat(Booking $booking, int $row, string $column): Seat
    {
        $seat = (new Seat)->fill(['row' => $row, 'column' => $column]);
        $seat->booking()->associate($booking);
        $seat->save();
        return $seat;
    }
}
