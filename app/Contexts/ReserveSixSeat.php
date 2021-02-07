<?php

namespace App\Contexts;

use App\Contexts\Contracts\SeatStrategy;
use App\DTO\SeatData;
use App\Repository\Contracts\SeatRepositoryContract;
use Illuminate\Support\Collection;

class ReserveSixSeat implements SeatStrategy
{
    public function reserve(int $booking_id, int $row, string $column, int $seats_to_reserve): Collection
    {
        $seats = collect();
        if ($column === 'A' || $column === 'B' || $column === 'C') {
            for ($i = 0; $i < $seats_to_reserve; $i++) {
                $next_column = chr(ord($column)+$i);
                $next_row = $row;

                if ($next_column === 'D' || $next_column === 'G') {
                    $next_column = 'A';
                } else if ($next_column === 'E' || $next_column === 'H') {
                    $next_column = 'B';
                } else if ($next_column === 'F' || $next_column === 'I') {
                    $next_column = 'C';
                }

                if ($column === 'A') {
                    if ($i === 3 || $i === 4 || $i === 5) {
                        $next_row = $row + 1;
                    }
                } else if ($column === 'B') {
                    if ($i === 2 || $i === 3 || $i === 4) {
                        $next_row = $row + 1;
                    } else if ($i === 5) {
                        $next_row = $row + 2;
                    }
                } else if ($column === 'C') {
                    if ($i === 1 || $i === 2 || $i === 3) {
                        $next_row = $row + 1;
                    } else if ($i === 4 || $i === 5) {
                        $next_row = $row + 2;
                    }
                }
                $dto = SeatData::fromArray([
                    'row'           => $next_row,
                    'column'        => $next_column,
                    'booking_id'    => $booking_id
                ]);
                $seat_repository = app(SeatRepositoryContract::class);
                $seats->add($seat_repository->store($dto));
            }
        } else if ($column === 'D' || $column === 'E' || $column === 'F') {
            for ($i = 0; $i < $seats_to_reserve; $i++) {
                $next_column = chr(ord($column)+$i);
                $next_row = $row;

                if ($next_column === 'G' || $next_column === 'J') {
                    $next_column = 'D';
                } else if ($next_column === 'H' || $next_column === 'K') {
                    $next_column = 'E';
                } else if ($next_column === 'I' || $next_column === 'L') {
                    $next_column = 'F';
                }

                if ($column === 'D') {
                    if ($i === 3 || $i === 4 || $i === 5) {
                        $next_row = $row + 1;
                    }
                } else if ($column === 'E') {
                    if ($i === 2 || $i === 3 || $i === 4) {
                        $next_row = $row + 1;
                    } else if ($i === 5) {
                        $next_row = $row + 2;
                    }
                } else if ($column === 'F') {
                    if ($i === 1 || $i === 2 || $i === 3) {
                        $next_row = $row + 1;
                    } else if ($i === 4 || $i === 5) {
                        $next_row = $row + 2;
                    }
                }
                $dto = SeatData::fromArray([
                    'row'           => $next_row,
                    'column'        => $next_column,
                    'booking_id'    => $booking_id
                ]);
                $seat_repository = app(SeatRepositoryContract::class);
                $seats->add($seat_repository->store($dto));
            }
        }
        return $seats;
    }
}
