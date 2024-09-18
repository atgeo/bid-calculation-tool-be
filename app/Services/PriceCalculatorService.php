<?php

namespace App\Services;

class PriceCalculatorService
{
    public function calculateTotalPrice(float $vehiclePrice, string $vehicleType): float
    {
        $buyerFeePercentage = 0.10 * $vehiclePrice;

        if ($vehicleType === 'luxury') {
            $minBuyerFee = 25;
            $maxBuyerFee = 200;
        } else {
            $minBuyerFee = 10;
            $maxBuyerFee = 50;
        }

        $buyerFee = max($minBuyerFee, min($maxBuyerFee, $buyerFeePercentage));
        $sellerFee = $this->calculateSellerFee($vehiclePrice, $vehicleType);
        $associationFee = $this->calculateAssociationFee($vehiclePrice);
        $storageFee = 100;

        return $vehiclePrice + $buyerFee + $sellerFee + $associationFee + $storageFee;
    }

    private function calculateSellerFee(float $vehiclePrice, string $vehicleType): float
    {
        $sellerFeePercentage = ($vehicleType === 'luxury') ? 0.04 : 0.02;

        return $sellerFeePercentage * $vehiclePrice;
    }

    private function calculateAssociationFee(float $vehiclePrice): float
    {
        if ($vehiclePrice <= 500) {
            $fee = 5;
        } elseif ($vehiclePrice < 1000) {
            $fee = 10;
        } elseif ($vehiclePrice < 3000) {
            $fee = 15;
        } else {
            $fee = 20;
        }

        return $fee;
    }
}
