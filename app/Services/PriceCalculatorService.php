<?php

namespace App\Services;

use App\Models\PricingRule;
use App\Repositories\PricingRuleRepository;

class PriceCalculatorService
{
    private PricingRuleRepository $pricingRuleRepo;

    private float $vehiclePrice;

    private PricingRule $pricingRule;

    public function __construct(PricingRuleRepository $pricingRuleRepo)
    {
        $this->pricingRuleRepo = $pricingRuleRepo;
    }

    public function calculateFeesAndTotalPrice(float $vehiclePrice, string $vehicleType): array
    {
        $pricingRule = $this->pricingRuleRepo->getPricingRules($vehicleType);

        $this->vehiclePrice = $vehiclePrice;
        $this->pricingRule = $pricingRule;

        $buyerFee = $this->calculateBuyerFee();
        $sellerFee = $this->calculateSellerFee();
        $associationFee = $this->calculateAssociationFee();
        $storageFee = $this->calculateStorageFee();

        return [
            'buyerFee' => $buyerFee,
            'sellerFee' => $sellerFee,
            'associationFee' => $associationFee,
            'storageFee' => $storageFee,
            'totalPrice' => $vehiclePrice + $buyerFee + $sellerFee + $associationFee + $storageFee,
        ];
    }

    private function calculateBuyerFee(): float
    {
        $minBuyerFee = $this->pricingRule->min_buyer_fee;
        $maxBuyerFee = $this->pricingRule->max_buyer_fee;
        $buyerFeeBase = $this->pricingRule->buyer_fee_percentage * $this->vehiclePrice;

        return  round(max($minBuyerFee, min($maxBuyerFee, $buyerFeeBase)), 2);
    }

    private function calculateSellerFee(): float
    {
        $sellerFeePercentage = $this->pricingRule->seller_fee_percentage;

        return round($sellerFeePercentage * $this->vehiclePrice, 2);
    }

    private function calculateAssociationFee(): float
    {
        $associationFee = $this->pricingRule->association_fee;

        if ($this->vehiclePrice <= 500) {
            $fee = $associationFee['1_to_500'];
        } elseif ($this->vehiclePrice <= 1000) {
            $fee = $associationFee['501_to_1000'];
        } elseif ($this->vehiclePrice <= 3000) {
            $fee = $associationFee['1001_to_3000'];
        } else {
            $fee = $associationFee['over_3000'];
        }

        return $fee;
    }

    private function calculateStorageFee(): float
    {
        return $this->pricingRule->storage_fee;
    }
}
