<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingStoreRequest;
use App\Http\Resources\SeatResource;
use App\Services\BookingService;

class BookingController extends Controller
{
    private BookingService $booking_service;

    public function __construct(
        BookingService $booking_service
    )
    {
        $this->booking_service = $booking_service;
    }

    public function store(BookingStoreRequest $request)
    {
        $seats = $this->booking_service->store($request->all());
        return SeatResource::collection($seats);
    }
}
