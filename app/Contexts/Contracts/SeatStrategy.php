<?php

namespace App\Contexts\Contracts;

use Illuminate\Support\Collection;

interface SeatStrategy
{
    public function reserve(int $booking_id, int $row, string $column, int $seats_to_reserve): Collection;
}
