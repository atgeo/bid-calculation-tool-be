<?php

namespace Tests\Unit;

use App\Enums\VehicleType;
use App\Models\PricingRule;
use App\Repositories\PricingRuleRepository;
use App\Services\PriceCalculatorService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CalculateTest extends TestCase
{
    protected PriceCalculatorService $priceCalculator;

    protected MockObject $pricingRuleRepoMock;

    protected MockObject $pricingRuleMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for the PricingRuleRepository
        $this->pricingRuleRepoMock = $this->createMock(PricingRuleRepository::class);

        $this->pricingRuleMock = $this->createMock(PricingRule::class);

        // Instantiate the PriceCalculatorService with the mocked repository
        $this->priceCalculator = new PriceCalculatorService($this->pricingRuleRepoMock);
    }

    public function test_calculate_function_common_57(): void
    {
        $vehiclePrice = 57;
        $vehicleType = VehicleType::COMMON->value;

        $pricingRuleCommon = PricingRule::factory()->state([
            'vehicle_type' => 'common',
            'buyer_fee_percentage' => 0.10,
            'min_buyer_fee' => 10,
            'max_buyer_fee' => 50,
            'seller_fee_percentage' => 0.02,
            'association_fee' => [
                '1_to_500' => 5,
                '501_to_1000' => 10,
                '1001_to_3000' => 15,
                'over_3000' => 20,
            ],
            'storage_fee' => 100.00
        ])->make();

        $this->pricingRuleRepoMock->expects($this->once())
            ->method('getPricingRules')
            ->with($vehicleType)
            ->willReturn($pricingRuleCommon);

        $result = $this->priceCalculator->calculateFeesAndTotalPrice($vehiclePrice, $vehicleType);

        $this->assertEquals(173.14, $result['totalPrice']);
        $this->assertEquals(10, $result['buyerFee']);
        $this->assertEquals(1.14, $result['sellerFee']);
        $this->assertEquals(5, $result['associationFee']);
        $this->assertEquals(100, $result['storageFee']);
    }

    public function test_calculate_function_luxury_1800(): void
    {
        $vehiclePrice = 1800;
        $vehicleType = VehicleType::LUXURY->value;

        $pricingRuleCommon = PricingRule::factory()->state([
            'vehicle_type' => 'luxury',
            'buyer_fee_percentage' => 0.10,
            'min_buyer_fee' => 25,
            'max_buyer_fee' => 200,
            'seller_fee_percentage' => 0.04,
            'association_fee' => [
                '1_to_500' => 5,
                '501_to_1000' => 10,
                '1001_to_3000' => 15,
                'over_3000' => 20,
            ],
            'storage_fee' => 100.00
        ])->make();

        $this->pricingRuleRepoMock->expects($this->once())
            ->method('getPricingRules')
            ->with($vehicleType)
            ->willReturn($pricingRuleCommon);

        $result = $this->priceCalculator->calculateFeesAndTotalPrice($vehiclePrice, $vehicleType);

        $this->assertEquals(2167, $result['totalPrice']);
        $this->assertEquals(180, $result['buyerFee']);
        $this->assertEquals(72, $result['sellerFee']);
        $this->assertEquals(15, $result['associationFee']);
        $this->assertEquals(100, $result['storageFee']);
    }
}
