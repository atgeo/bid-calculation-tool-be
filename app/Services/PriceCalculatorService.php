<?php

namespace App\Services;

use App\Repositories\PricingRuleRepository;

class PriceCalculatorService
{
    protected PricingRuleRepository $pricingRuleRepo;

    public function __construct(PricingRuleRepository $pricingRuleRepo)
    {
        $this->pricingRuleRepo = $pricingRuleRepo;
    }

    public function calculateFeesAndTotalPrice(float $vehiclePrice, string $vehicleType): array
    {
        $pricingRules = $this->pricingRuleRepo->getPricingRules($vehicleType);

        $buyerFeePercentage = $pricingRules->buyer_fee_percentage * $vehiclePrice;

        $minBuyerFee = $pricingRules->min_buyer_fee;
        $maxBuyerFee = $pricingRules->max_buyer_fee;
        $storageFee = $pricingRules->storage_fee;
        $sellerFeePercentage = $pricingRules->seller_fee_percentage;

        $buyerFee = max($minBuyerFee, min($maxBuyerFee, $buyerFeePercentage));
        $sellerFee = $this->calculateSellerFee($vehiclePrice, $sellerFeePercentage);
        $associationFee = $this->calculateAssociationFee($vehiclePrice, $pricingRules->association_fee);

        return [
            'buyer_fee' => $buyerFee,
            'seller_fee' => $sellerFee,
            'association_fee' => $associationFee,
            'storage_fee' => $storageFee,
            'total_price' => $vehiclePrice + $buyerFee + $sellerFee + $associationFee + $storageFee,
        ];
    }

    private function calculateSellerFee(string $sellerFeePercentage, float $vehiclePrice, ): float
    {
        return $sellerFeePercentage * $vehiclePrice;
    }

    private function calculateAssociationFee(float $vehiclePrice, array $associationFee): float
    {
        if ($vehiclePrice <= 500) {
            $fee = $associationFee['1_to_500'];
        } elseif ($vehiclePrice < 1000) {
            $fee = $associationFee['501_to_1000'];
        } elseif ($vehiclePrice < 3000) {
            $fee = $associationFee['1001_to_3000'];
        } else {
            $fee = $associationFee['over_3000'];
        }

        return $fee;
    }
}
