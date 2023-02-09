<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanFeature;
use Exception;
use Illuminate\Http\Request;

class UserPlanFeatureController extends Controller
{
    use ApiResponse;
    public function store(Request $request)
    {
        try {
            $planFeature = $this->getPlanFeature($request['plan_id']);

            return $planFeature;
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getCode());
        }
    }

    public function getPlanFeature($planId)
    {
        $planFeature = Plan::with(['features' => function ($q) {
            $q->select('features.id as feature_id', 'unique_key', 'access_value');
        }])->where('id', $planId)->select('id')->first();

        if (!$planFeature) {
            throw new Exception("Data Not found", 404);
        }
        return $planFeature;
    }
}
