<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FeatureResources;
use App\Http\Resources\v1\PricePlanResources;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\PriceType;
use Illuminate\Http\Request;


class PlanFeatureController extends Controller
{
    use ApiResponse;
    public function featurePlan()
    {

        // return $this->success(Feature::with('plans')->get());
        $featurePlan = Feature::with(['plans' => function ($q) {
            $q->select('plan_name', 'access', 'access_value');
        }])->select('id', 'name', 'unique_key')->get();
        return $this->success(new FeatureResources($featurePlan));
    }
    public function plans()
    {
        // return Plan::with('features')->get();
        return $this->success(Plan::select('id', 'plan_name', 'business_type')->get());
    }

    public function planFeature()
    {
        // return Plan::with('features')->get();
        $planFeatures = Plan::with(['features' => function ($q) {
            $q->select('name', 'unique_key', 'access', 'access_value');
        }])->select('id', 'plan_name')->get();
        return $this->success(new FeatureResources($planFeatures));
    }

    public function pricePlan()
    {
        $pricetypePlan = PriceType::with(['plans' => function ($q) {
            $q->select('plan_name', 'business_type', 'amount', 'currency');
        }])->select('id', 'price_type_name', 'description')->get();
        return $this->success(new PricePlanResources($pricetypePlan));
    }

    public function planPrice()
    {
        $planPrice = Plan::with(['pricesTypes' => function ($q) {
            $q->select('price_type_name', 'amount', 'currency');
        }])->select('id', 'plan_name', 'business_type')->get();
        return $this->success(new PricePlanResources($planPrice));
    }
}
