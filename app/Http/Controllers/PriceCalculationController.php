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
        $vehiclePrice = $request->input('vehiclePrice');
        $vehicleType = $request->input('vehicleType');

        $feesAndTotalPrice = $this->priceCalculator->calculateFeesAndTotalPrice($vehiclePrice, $vehicleType);

        return response()->json($feesAndTotalPrice);
    }
}
