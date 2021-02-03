<?php declare(strict_types=1);

namespace App\Repository;

use App\Repository\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryContract
{
    protected abstract function model(): Model;

    public function all(): Collection {
        return $this->model()->all();
    }

    public function query(): Builder {
        return $this->model()->newQuery();
    }

    public function with(array $array): Builder {
        return $this->model()->with($array);
    }

    public function findMany(string $column, array $values, array $columnsToGet = ['*']): Collection {
        return $this->query()
            ->whereIn($column, $values)
            ->get($columnsToGet);
    }
}
