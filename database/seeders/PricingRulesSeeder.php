<?php

namespace Database\Seeders;

use App\Models\PricingRule;
use Illuminate\Database\Seeder;

class PricingRulesSeeder extends Seeder
{
    public function run(): void
    {
        PricingRule::create([
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
            'storage_fee' => 100,
        ]);

        PricingRule::create([
            'vehicle_type' => 'luxury',
            'buyer_fee_percentage' => 0.10,
            'min_buyer_fee' => 25,
            'max_buyer_fee' => 200,
            'seller_fee_percentage' => 0.04,
            'association_fee' => [
                '1_to_500' => 5.00,
                '501_to_1000' => 10.00,
                '1001_to_3000' => 15.00,
                'over_3000' => 20.00,
            ],
            'storage_fee' => 100,
        ]);
    }
}
