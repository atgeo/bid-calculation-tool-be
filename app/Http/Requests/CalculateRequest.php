<?php

namespace App\Http\Requests;

use App\Enums\VehicleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CalculateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehiclePrice' => 'required|numeric|min:1',
            'vehicleType' => ['required', new Enum(VehicleType::class)],
        ];
    }
}
