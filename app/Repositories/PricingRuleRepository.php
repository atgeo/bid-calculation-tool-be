<?php

namespace App\Repositories;

use App\Models\PricingRule;
use Illuminate\Database\Eloquent\Collection;

class PricingRuleRepository
{
    public function getPricingRules(string $type): PricingRule
    {
        return PricingRule::where('type', $type)->first();
    }
}
