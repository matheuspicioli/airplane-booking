<?php

namespace App\Http\Controllers;

use App\Actions\CreateAirplaneStructure;
use App\Models\Seat;
use App\Repository\Contracts\BookingRepositoryContract;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BookingRepositoryContract $booking_repository;

    public function __construct(BookingRepositoryContract $booking_repository)
    {
        $this->booking_repository = $booking_repository;
    }

    public function store(Request $request)
    {
        $booking = $this->booking_repository->findOrFail(1);
        $seats_alread_booked = $booking->seats->map(function (Seat $seat) {
            return $seat->description;
        })->toArray();

        dd($seats_alread_booked);

        if ($request->get('seats') > 7) {
            /**
             * @TODO: criar e implementar exception para retornar um json
             */
            return;
        }

        $airplane_structure = (new CreateAirplaneStructure($request->all()))();
        $rows = $airplane_structure['rows'];

        collect($airplane_structure['row_arrangement'])
            ->each(function ($column) use ($rows) {
                if ($column === '_') {
                    return;
                }
                collect($rows)->each(function ($row) use ($column) {
                    echo $column.$row."\n";
                });
            });
    }
}
