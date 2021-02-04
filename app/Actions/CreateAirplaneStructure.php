<?php

namespace App\Actions;

use App\Models\Aircraft;
use Illuminate\Support\Collection;

class CreateAirplaneStructure
{
    private array $data;
    private Aircraft $aircraft;
    private array $rows;

    public function __construct(array $data)
    {
        $aircraft = Aircraft::findOrFail(1);
        $this->aircraft = $aircraft;
        $this->data = $data;
        $rows = [];

        for ($i = 1; $i <= $this->aircraft->rows; $i++) {
            $rows[] = $i;
        }

        $this->rows = $rows;
    }

    public function __invoke(): Collection
    {
        return collect([
            'row_arrangement'   => $this->aircraft->row_arrangement_array,
            'rows'              => $this->rows,
        ]);
    }
}
