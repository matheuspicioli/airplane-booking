<?php

namespace App\Repository\Contracts;

use App\DTO\SeatData;
use App\Models\Seat;
use Illuminate\Support\Collection;

interface SeatRepositoryContract
{
    public function all(): Collection;

    public function find(int $id): ?Seat;

    public function findOrFail(int $id): Seat;

    public function store(SeatData $data): Seat;

    public function update(int $id, SeatData $data): Seat;

    public function destroy(int $id): ?Seat;
}
