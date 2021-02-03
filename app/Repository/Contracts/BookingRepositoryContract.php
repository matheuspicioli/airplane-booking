<?php

namespace App\Repository\Contracts;

use App\DTO\BookingData;
use App\Models\Booking;
use Illuminate\Support\Collection;

interface BookingRepositoryContract
{
    public function all(): Collection;

    public function find(int $id): ?Booking;

    public function findOrFail(int $id): Booking;

    public function store(BookingData $data): Booking;

    public function update(int $id, BookingData $data): Booking;

    public function destroy(int $id): ?Booking;
}
