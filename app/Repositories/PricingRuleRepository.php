<?php

namespace App\Repositories;

use App\Models\PricingRule;

class PricingRuleRepository
{
    public function getPricingRules(string $vehicleType): PricingRule
    {
        return PricingRule::where('vehicle_type', $vehicleType)->first();
    }
}
