<?php

namespace App\Http\Controllers;

use App\Actions\CreateAirplaneStructure;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $structure = (new CreateAirplaneStructure)();
        dd($structure);
    }
}
