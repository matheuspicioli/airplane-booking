<?php declare(strict_types=1);

namespace App\Repository;

use App\DTO\SeatData;
use App\Models\Seat;
use App\Repository\Contracts\SeatRepositoryContract;
use Illuminate\Support\Collection;

class SeatRepository extends BaseRepository implements SeatRepositoryContract
{
    protected function model(): Seat
    {
        return new Seat;
    }

    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    public function find(int $id): ?Seat
    {
        return $this->model()->find($id);
    }

    public function findOrFail(int $id): Seat
    {
        return $this->model()->findOrFail($id);
    }

    public function store(SeatData $data): Seat
    {
        $model = $this->model();
        $model->fill($data->except('booking')->toArray());
        $model->booking()->associate($data->booking);
        $model->save();

        return $model;
    }

    public function update(int $id, SeatData $data): Seat
    {
        $model = $this->findOrFail($id);
        $model->fill($data->except('booking')->toArray());
        $model->booking()->associate($data->booking);
        $model->save();

        return $model;
    }

    public function destroy(int $id): ?Seat
    {
        $model = $this->findOrFail($id);
        $model->delete();

        return $model;
    }
}
