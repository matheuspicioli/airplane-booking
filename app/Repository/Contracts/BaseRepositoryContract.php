<?php

namespace App\Repository\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface BaseRepositoryContract
{
    public function all(): Collection;

    public function query(): Builder;

    public function with(array $array): Builder;

    public function findMany(string $column, array $values, array $columnsToGet = ['*']): Collection;
}
