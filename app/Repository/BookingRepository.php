<?php declare(strict_types=1);

namespace App\Repository;

use App\DTO\BookingData;
use App\Models\Booking;
use App\Repository\Contracts\BookingRepositoryContract;
use Illuminate\Support\Collection;

class BookingRepository extends BaseRepository implements BookingRepositoryContract
{
    protected function model(): Booking
    {
        return new Booking;
    }

    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    public function find(int $id): ?Booking
    {
        return $this->model()->find($id);
    }

    public function findOrFail(int $id): Booking
    {
        return $this->model()->findOrFail($id);
    }

    public function store(BookingData $data): Booking
    {
        $model = $this->model();
        $model->fill($data->except('customer')->toArray());
        $model->save();

        return $model;
    }

    public function update(int $id, BookingData $data): Booking
    {
        $model = $this->findOrFail($id);
        $model->fill($data->toArray());
        $model->save();

        return $model;
    }

    public function destroy(int $id): ?Booking
    {
        $model = $this->findOrFail($id);
        $model->delete();

        return $model;
    }
}
