<?php

namespace App\Actions;

class CreateAirplaneStructure
{
    private array $cols;
    private array $rows;

    public function __construct()
    {
        $this->cols = ['A', 'B', 'C', '_', 'D', 'E', 'F'];
        $rows = [];

        for ($i = 1; $i <=26; $i++) {
            $rows[] = $i;
        }

        $this->rows = $rows;
    }

    public function __invoke()
    {
        return [
            'cols' => $this->cols,
            'rows' => $this->rows,
        ];
    }
}
