<?php

namespace App;

use App\Models\Seat;

class SeatHelper
{
    public static function showAllSeats(): array
    {
        return Seat::all()->map(fn($seat) => $seat->column.$seat->row)->toArray();
    }
}
