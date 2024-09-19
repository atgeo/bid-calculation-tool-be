<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PricingRuleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehicle_type' =>  fake()->randomElement(['common', 'luxury']),
            'buyer_fee_percentage' => fake()->randomFloat(2, 0.01, 0.20),
            'min_buyer_fee' => fake()->randomFloat(2, 5, 100),
            'max_buyer_fee' => fake()->randomFloat(2, 10, 500),
            'seller_fee_percentage' => fake()->randomFloat(2, 0.01, 0.20),
            'association_fee' => [
                '1_to_500' => fake()->numberBetween(1, 10),
                '501_to_1000' => fake()->numberBetween(5, 20),
                '1001_to_3000' => fake()->numberBetween(10, 25),
                'over_3000' => fake()->numberBetween(10, 30),
            ],
            'storage_fee' => fake()->randomFloat(2, 50, 200),
        ];
    }
}
