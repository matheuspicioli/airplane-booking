<?php

namespace App\Http\Controllers;

use App\Actions\CreateAirplaneStructure;
use App\Http\Resources\SeatResource;
use App\Repository\Contracts\BookingRepositoryContract;
use App\SeatHelper;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BookingRepositoryContract $booking_repository;
    private BookingService $booking_service;

    public function __construct(
        BookingRepositoryContract $booking_repository,
        BookingService $booking_service
    )
    {
        $this->booking_repository = $booking_repository;
        $this->booking_service = $booking_service;
    }

    public function store(Request $request)
    {
//        dd(SeatHelper::columnAlphabet(Aircraft::find(1)));
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
        $seats = collect();

        /**
         * @TODO: analise all resets column to A, in same cases is need reset to D
         * @TODO: use the length and postion array to decide if is A or D /\
         */
        foreach ($rows as $row) {
            foreach ($airplane_structure['row_arrangement'] as $column) {
                if ($column === '_' || $seats_alread_booked->contains($column.$row)) {
                    continue;
                }

                // 3 is the max seats per row arrangement
                if ($seats_to_reserve === 1) {
                    $seats->add(SeatHelper::createSeat($booking, $row, $column));
                    return SeatResource::collection($seats);
                } else if ($seats_to_reserve === 2) {
                    if ($column === 'A' || $column === 'B' || $column === 'D' || $column === 'E') {
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_column = chr(ord($column)+$i);
                            $seats->add(SeatHelper::createSeat($booking, $row, $next_column));
                        }
                    } else if ($column === 'C' || $column === 'F') {
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_row = $row+$i;
                            $next_column = $column;
                            if ($i === 1) {
                                $next_column = $column === 'C' ? 'A' : 'D';
                            }
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    }

                    return SeatResource::collection(collect($seats));
                } else if ($seats_to_reserve === 3) {
                    if ($column === 'A' || $column === 'D') {
                        // Booking in the same row, until 3 columns
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_column = chr(ord($column)+$i);
                            $seats->add(SeatHelper::createSeat($booking, $row, $next_column));
                        }
                    } else if ($column === 'B' || $column === 'E'){
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_row = $row;
                            $next_column = chr(ord($column)+$i);
                            if ($i === 2) {
                                $next_row = $row+$i;
                                $next_column = $column === 'B' ? 'A' : 'D';
                            }
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    } else if ($column === 'C' || $column === 'F') {
                        // Is not verified the nexts columns
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_row = $row+$i;
                            $next_column = $column;
                            if ($i === 1) {
                                $next_column = $column === 'C' ? 'A' : 'D';
                            } else if ($i === 2) {
                                $next_column = $column === 'C' ? 'B' : 'E';
                                $next_row = $next_row - 1;
                            }
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    }

                    return SeatResource::collection($seats);
                } else if ($seats_to_reserve === 4) {
                    if ($column === 'A' || $column === 'D') {
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_column = chr(ord($column)+$i);
                            $next_row = $row;

                            if ($i === 3) {
                                $next_row = $next_row + 1;
                                $next_column = $column;
                            }
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
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
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
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
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    }
                    return SeatResource::collection($seats);
                } else if ($seats_to_reserve === 5) {
                    /**
                     * Identify the first or second side of aisle
                     */
                    if ($column === 'A' || $column === 'B' || $column === 'C') {
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_column = chr(ord($column)+$i);
                            $next_row = $row;

                            if ($next_column === 'D' || $next_column === 'G') {
                                $next_column = 'A';
                            } else if ($next_column === 'E') {
                                $next_column = 'B';
                            } else if ($next_column === 'F') {
                                $next_column = 'C';
                            }

                            if ($column === 'A') {
                                if ($i === 3 || $i === 4) {
                                    $next_row = $next_row + 1;
                                }
                            } else if ($column === 'B') {
                                if ($i === 2 || $i === 3 || $i === 4) {
                                    $next_row = $next_row + 1;
                                }
                            } else if ($column === 'C') {
                                if ($i === 1 || $i === 2 || $i === 3) {
                                    $next_row = $next_row + 1;
                                } else if ($i === 4) {
                                    $next_row = $next_row + 2;
                                }
                            }
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    } else if ($column === 'D' || $column === 'E' || $column === 'F') {
                        for ($i = 0; $i < $seats_to_reserve; $i++) {
                            $next_column = chr(ord($column)+$i);
                            $next_row = $row;

                            if ($next_column === 'G' || $next_column === 'J') {
                                $next_column = 'D';
                            } else if ($next_column === 'H') {
                                $next_column = 'E';
                            } else if ($next_column === 'I') {
                                $next_column = 'F';
                            }

                            if ($column === 'D') {
                                if ($i === 3 || $i === 4) {
                                    $next_row = $next_row + 1;
                                }
                            } else if ($column === 'E') {
                                if ($i === 2 || $i === 3 || $i === 4) {
                                    $next_row = $next_row + 1;
                                }
                            } else if ($column === 'F') {
                                if ($i === 1 || $i === 2 || $i === 3) {
                                    $next_row = $next_row + 1;
                                } else if ($i === 4) {
                                    $next_row = $next_row + 2;
                                }
                            }
                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    }
                    return SeatResource::collection($seats);
                } else if ($seats_to_reserve === 6) {
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

                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
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

                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    }
                    return SeatResource::collection($seats);
                } else if ($seats_to_reserve === 7) {
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
                                } else if ($i === 6) {
                                    $next_row = $row + 2;
                                }
                            } else if ($column === 'B') {
                                if ($i === 2 || $i === 3 || $i === 4) {
                                    $next_row = $row + 1;
                                } else if ($i === 5 || $i === 6) {
                                    $next_row = $row + 2;
                                }
                            } else if ($column === 'C') {
                                if ($i === 1 || $i === 2 || $i === 3) {
                                    $next_row = $row + 1;
                                } else if ($i === 4 || $i === 5 || $i === 6) {
                                    $next_row = $row + 2;
                                }
                            }

                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
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
                                } else if ($i === 6) {
                                    $next_row = $row + 2;
                                }
                            } else if ($column === 'E') {
                                if ($i === 2 || $i === 3 || $i === 4) {
                                    $next_row = $row + 1;
                                } else if ($i === 5 || $i === 6) {
                                    $next_row = $row + 2;
                                }
                            } else if ($column === 'F') {
                                if ($i === 1 || $i === 2 || $i === 3) {
                                    $next_row = $row + 1;
                                } else if ($i === 4 || $i === 5 || $i === 6) {
                                    $next_row = $row + 2;
                                }
                            }

                            $seats->add(SeatHelper::createSeat($booking, $next_row, $next_column));
                        }
                    }
                    return SeatResource::collection($seats);
                }
            }
        }
    }
}
