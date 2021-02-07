<?php

namespace App\Http\Requests;

class BookingStoreRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'passenger_name'    => 'required',
            'seats'             => 'required|numeric|max:7',
        ];
    }
}
