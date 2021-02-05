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
//        dd(Seat::all());
        $seats_to_reserve = $request->get('seats');
        $booking = $this->booking_repository->findOrFail(1);
        $seats_alread_booked = $booking->seats->map(fn($seat) => $seat->column.$seat->row);

        if ($seats_to_reserve > 7) {
            /**
             * @TODO: criar e implementar exception para retornar um json
             */
            return;
        }

        $airplane_structure = (new CreateAirplaneStructure($request->all()))();
        $rows = $airplane_structure['rows'];

        foreach ($rows as $row) {
            foreach ($airplane_structure['row_arrangement'] as $column) {
                if ($column === '_' || $seats_alread_booked->contains($column.$row)) {
                    continue;
                }

                // 3 is the max seats per row arrangement
                if ($seats_to_reserve === 1) {
                    $seat = (new Seat)->fill(['row' => $row, 'column' => $column]);
                    $seat->booking()->associate($booking);
                    $seat->save();
                    dd(Seat::all());
                    break;
                } else if ($seats_to_reserve === 2) {
                    if ($column === 'A' || $column === 'B' || $column === 'D' || $column === 'E') {
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_column = chr(ord($column)+$i);
                            $seat = (new Seat)->fill(['row' => $row, 'column' => $next_column]);
                            $seat->booking()->associate($booking);
                            $seat->save();
                        }
                    } else {
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_row = $row+$i;
                            $next_column = $column;
                            if ($i === 1) {
                                $next_column = 'A';
                            }
                            $seat = (new Seat)->fill(['row' => $next_row, 'column' => $next_column]);
                            $seat->booking()->associate($booking);
                            $seat->save();
                        }
                    }
                    dd(Seat::all());
                    break;
                } else if ($seats_to_reserve === 3) {
                    if ($column === 'A' || $column === 'D') {
                        // Booking in the same row, until 3 columns
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_column = chr(ord($column)+$i);
                            $seat = (new Seat)->fill(['row' => $row, 'column' => $next_column]);
                            $seat->booking()->associate($booking);
                            $seat->save();
                        }
                    } else if ($column === 'B' || $column === 'E'){
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_row = $row;
                            $next_column = chr(ord($column)+$i);
                            if ($i === 2) {
                                $next_row = $row+$i;
                                $next_column = 'A';
                            }
                            $seat = (new Seat)->fill(['row' => $next_row, 'column' => $next_column]);
                            $seat->booking()->associate($booking);
                            $seat->save();
                        }
                    } else if ($column === 'C' || $column === 'F') {
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_row = $row+$i;
                            $next_column = $column;
                            if ($i === 1) {
                                $next_column = 'A';
                            } else if ($i === 2) {
                                $next_column = 'B';
                                $next_row = $next_row - 1;
                            }
                            $seat = (new Seat)->fill(['row' => $next_row, 'column' => $next_column]);
                            $seat->booking()->associate($booking);
                            $seat->save();
                        }
                    }
                    dd(Seat::all());
                    break;
                } else if ($seats_to_reserve === 4) {
                } else if ($seats_to_reserve === 5) {
                } else if ($seats_to_reserve === 6) {
                } else if ($seats_to_reserve === 7) {
                }
                break;
            }
        }
    }
}
