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
    private PriceCalculatorService $priceCalculator;

    private MockObject $pricingRuleRepoMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for the PricingRuleRepository
        $this->pricingRuleRepoMock = $this->createMock(PricingRuleRepository::class);

        // Instantiate the PriceCalculatorService with the mocked repository
        $this->priceCalculator = new PriceCalculatorService($this->pricingRuleRepoMock);
    }

    public function test_calculate_function_common_57(): void
    {
        $vehiclePrice = 57;
        $vehicleType = VehicleType::COMMON->value;

        $this->mockPricingRule(
            $vehicleType,
            0.10,
            10,
            50,
            0.02,
            [
                '1_to_500' => 5,
                '501_to_1000' => 10,
                '1001_to_3000' => 15,
                'over_3000' => 20,
            ],
            100
        );

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

        $this->mockPricingRule(
            $vehicleType,
            0.10,
            25,
            200,
            0.04,
            [
                '1_to_500' => 5,
                '501_to_1000' => 10,
                '1001_to_3000' => 15,
                'over_3000' => 20,
            ],
            100
        );

        $result = $this->priceCalculator->calculateFeesAndTotalPrice($vehiclePrice, $vehicleType);

        $this->assertEquals(2167, $result['totalPrice']);
        $this->assertEquals(180, $result['buyerFee']);
        $this->assertEquals(72, $result['sellerFee']);
        $this->assertEquals(15, $result['associationFee']);
        $this->assertEquals(100, $result['storageFee']);
    }

    public function test_calculate_function_luxury_1000000(): void
    {
        $vehiclePrice = 1000000;
        $vehicleType = VehicleType::LUXURY->value;

        $this->mockPricingRule(
            $vehicleType,
            0.10,
            25,
            200,
            0.04,
            [
                '1_to_500' => 5,
                '501_to_1000' => 10,
                '1001_to_3000' => 15,
                'over_3000' => 20,
            ],
            100.00
        );

        $result = $this->priceCalculator->calculateFeesAndTotalPrice($vehiclePrice, $vehicleType);

        $this->assertEquals(1040320, $result['totalPrice']);
        $this->assertEquals(200, $result['buyerFee']);
        $this->assertEquals(40000, $result['sellerFee']);
        $this->assertEquals(20, $result['associationFee']);
        $this->assertEquals(100, $result['storageFee']);
    }

    private function mockPricingRule(
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
