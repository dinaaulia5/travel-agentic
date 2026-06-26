<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'airline_id' => [
                'required',
                'exists:airlines,id',
            ],

            'departure_airport_id' => [
                'required',
                'exists:airports,id',
            ],

            'arrival_airport_id' => [
                'required',
                'exists:airports,id',
                'different:departure_airport_id',
            ],

            'flight_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('flights', 'flight_number')
                    ->ignore($this->route('flight')),
            ],

            'scheduled_departure' => [
                'required',
                'date',
            ],

            'scheduled_arrival' => [
                'required',
                'date',
                'after:scheduled_departure',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'on_time',
                    'boarding',
                    'delayed',
                    'departed',
                    'arrived',
                    'cancelled',
                ]),
            ],

            'delay_minutes' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'reason' => [
                'nullable',
                'string',
            ],

            'actual_departure' => [
                'nullable',
                'date',
            ],

            'actual_arrival' => [
                'nullable',
                'date',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'airline_id' => 'maskapai',
            'departure_airport_id' => 'bandara keberangkatan',
            'arrival_airport_id' => 'bandara tujuan',
            'flight_number' => 'nomor penerbangan',
            'scheduled_departure' => 'jadwal keberangkatan',
            'scheduled_arrival' => 'jadwal kedatangan',
            'price' => 'harga tiket',

            'status' => 'status penerbangan',
            'delay_minutes' => 'durasi keterlambatan',
            'reason' => 'alasan',
            'actual_departure' => 'actual departure',
            'actual_arrival' => 'actual arrival',
        ];
    }
}
