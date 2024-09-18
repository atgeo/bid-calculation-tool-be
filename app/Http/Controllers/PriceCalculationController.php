<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceCalculationController extends Controller
{
    public function calculate(Request $request): JsonResponse
    {
        return response()->json(['total_price' => 0]);
    }
}
