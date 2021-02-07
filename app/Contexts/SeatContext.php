<?php

namespace App\Contexts;

use App\Contexts\Contracts\SeatStrategy;
use Illuminate\Support\Collection;

class SeatContext
{
    private SeatStrategy $seat_strategy;

    public function __construct(SeatStrategy $strategy)
    {
        $this->seat_strategy = $strategy;
    }

    public function reserve(int $booking_id, int $row, string $column, int $seats_to_reserve): Collection
    {
        return $this->seat_strategy->reserve($booking_id, $row, $column, $seats_to_reserve);
    }
}
