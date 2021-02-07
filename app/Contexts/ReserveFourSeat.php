<?php

namespace App\Contexts;

use App\Contexts\Contracts\SeatStrategy;
use App\DTO\SeatData;
use App\Repository\Contracts\SeatRepositoryContract;
use Illuminate\Support\Collection;

class ReserveFourSeat implements SeatStrategy
{
    public function reserve(int $booking_id, int $row, string $column, int $seats_to_reserve): Collection
    {
        $seats = collect();
        if ($column === 'A' || $column === 'D') {
            for ($i = 0; $i < $seats_to_reserve; $i++) {
                $next_column = chr(ord($column)+$i);
                $next_row = $row;

                if ($i === 3) {
                    $next_row = $next_row + 1;
                    $next_column = $column;
                }
                $dto = SeatData::fromArray([
                    'row'           => $next_row,
                    'column'        => $next_column,
                    'booking_id'    => $booking_id
                ]);
                $seat_repository = app(SeatRepositoryContract::class);
                $seats->add($seat_repository->store($dto));
            }
        } else if ($column === 'B' || $column === 'E') {
            for ($i = 0; $i < $seats_to_reserve; $i++) {
                $next_column = chr(ord($column)+$i);
                $next_row = $row;

                if ($i === 2) {
                    $next_row = $next_row + 1;
                    $next_column = $column === 'B' ? 'A' : 'D';
                } else if ($i === 3) {
                    /**
                     * Keep the next row, because on the init loop the row is reseted
                     */
                    $next_row = $next_row + 1;
                    $next_column = $column;
                }
                $dto = SeatData::fromArray([
                    'row'           => $next_row,
                    'column'        => $next_column,
                    'booking_id'    => $booking_id
                ]);
                $seat_repository = app(SeatRepositoryContract::class);
                $seats->add($seat_repository->store($dto));
            }
        } else if ($column === 'C' || $column === 'F') {
            for ($i = 0; $i < $seats_to_reserve; $i++) {
                $next_column = chr(ord($column)+$i);
                $next_row = $row;

                if ($i === 1) {
                    $next_column = 'A';
                    $next_row = $next_row + 1;
                } else if ($i === 2) {
                    $next_column = 'B';
                    $next_row = $next_row + 1;
                } else if ($i === 3) {
                    $next_column = 'C';
                    $next_row = $next_row + 1;
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
