<?php

namespace Tests\Unit;

use App\Models\PricingRule;
use App\Repositories\PricingRuleRepository;
use App\Services\PriceCalculatorService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class BasePriceCalculatorTest extends TestCase
{
    protected MockObject $pricingRuleRepoMock;
    protected PriceCalculatorService $priceCalculator;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for the PricingRuleRepository
        $this->pricingRuleRepoMock = $this->createMock(PricingRuleRepository::class);

        // Instantiate the PriceCalculatorService with the mocked repository
        $this->priceCalculator = new PriceCalculatorService($this->pricingRuleRepoMock);
    }

    protected function mockPricingRule(
        string $vehicleType,
        float  $buyerFeePercentage,
        float  $minBuyerFee,
        float  $maxBuyerFee,
        float  $sellerFeePercentage,
        array  $associationFee,
        float  $storageFee
    ): void
    {
        $pricingRule = PricingRule::factory()->state([
            'vehicle_type' => $vehicleType,
            'buyer_fee_percentage' => $buyerFeePercentage,
            'min_buyer_fee' => $minBuyerFee,
            'max_buyer_fee' => $maxBuyerFee,
            'seller_fee_percentage' => $sellerFeePercentage,
            'association_fee' => $associationFee,
            'storage_fee' => $storageFee
        ])->make();

        $this->pricingRuleRepoMock->expects($this->once())
            ->method('getPricingRules')
            ->with($vehicleType)
            ->willReturn($pricingRule);
    }
}
