<?php

namespace App\Http\Controllers;

use App\Services\PriceCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceCalculationController extends Controller
{
    protected PriceCalculatorService $priceCalculator;

    public function __construct(PriceCalculatorService $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function calculate(Request $request): JsonResponse
    {
        $vehiclePrice = $request->input('vehicle_price');
        $vehicleType = $request->input('vehicle_type');

        $totalPrice = $this->priceCalculator->calculateTotalPrice($vehiclePrice, $vehicleType);

        return response()->json(['total_price' => $totalPrice]);
    }
}
