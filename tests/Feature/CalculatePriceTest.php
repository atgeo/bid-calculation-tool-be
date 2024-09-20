<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculatePriceTest extends TestCase
{
    public function test_calculate_price_common_1000000(): void
    {
        $response = $this->post('/api/calculate-price', [
            'vehiclePrice' => '1000000',
            'vehicleType' => 'luxury',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'buyerFee' => 200,
            'sellerFee' => 40000,
            'associationFee' => 20,
            'storageFee' => 100,
            'totalPrice' => 1040320,
        ]);
    }
}
