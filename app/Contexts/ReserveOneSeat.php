<?php

namespace App\Contexts;

use App\Contexts\Contracts\SeatStrategy;
use App\DTO\SeatData;
use App\Repository\Contracts\SeatRepositoryContract;
use Illuminate\Support\Collection;

class ReserveOneSeat implements SeatStrategy
{
    public function reserve(int $booking_id, int $row, string $column, int $seats_to_reserve): Collection
    {
        $dto = SeatData::fromArray([
            'row'           => $row,
            'column'        => $column,
            'booking_id'    => $booking_id
        ]);
        $seat_repository = app(SeatRepositoryContract::class);
        return collect()->add($seat_repository->store($dto));
    }
}
