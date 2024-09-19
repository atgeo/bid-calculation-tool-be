<?php

namespace Tests\Unit;

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
}
