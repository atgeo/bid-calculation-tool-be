<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateRequest;
use App\Services\PriceCalculatorService;
use Illuminate\Http\JsonResponse;

class PriceCalculationController extends Controller
{
    protected PriceCalculatorService $priceCalculator;

    public function __construct(PriceCalculatorService $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function calculate(CalculateRequest $request): JsonResponse
    {
        $vehiclePrice = $request->input('vehiclePrice');
        $vehicleType = $request->input('vehicleType');

        $feesAndTotalPrice = $this->priceCalculator->calculateFeesAndTotalPrice($vehiclePrice, $vehicleType);

        return response()->json($feesAndTotalPrice);
    }
}
