<?php

namespace App\Services;

use App\Actions\CreateAirplaneStructure;
use App\Contexts\ReserveFiveSeat;
use App\Contexts\ReserveFourSeat;
use App\Contexts\ReserveOneSeat;
use App\Contexts\ReserveSevenSeat;
use App\Contexts\ReserveSixSeat;
use App\Contexts\ReserveThreeSeat;
use App\Contexts\ReserveTwoSeat;
use App\Contexts\SeatContext;
use App\Repository\Contracts\BookingRepositoryContract;
use App\Services\Contracts\ServiceContract;
use Illuminate\Support\Collection;

class BookingService implements ServiceContract
{
    private BookingRepositoryContract $booking_repository;

    public function __construct(BookingRepositoryContract $booking_repository)
    {
        $this->booking_repository = $booking_repository;
    }

    public function store(array $data): Collection
    {
        $seats_to_reserve = $data['seats'];
        $booking = $this->booking_repository->findOrFail(1);
        $seats_alread_booked = $booking->seats->map(fn($seat) => $seat->column.$seat->row);
        $airplane_structure = (new CreateAirplaneStructure)();
        $strategies_by_seats = [
            1 => new ReserveOneSeat,
            2 => new ReserveTwoSeat,
            3 => new ReserveThreeSeat,
            4 => new ReserveFourSeat,
            5 => new ReserveFiveSeat,
            6 => new ReserveSixSeat,
            7 => new ReserveSevenSeat,
        ];

        foreach ($airplane_structure['rows'] as $row) {
            foreach ($airplane_structure['row_arrangement'] as $column) {
                if ($column === '_' || $seats_alread_booked->contains($column.$row)) {
                    continue;
                }

                $strategy = $strategies_by_seats[$seats_to_reserve];
                $context = new SeatContext($strategy);
                return $context->reserve($booking->id, $row, $column, $seats_to_reserve);
            }
        }
    }
}
