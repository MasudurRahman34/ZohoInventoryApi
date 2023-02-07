<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanFeaturePermissionController extends Controller
{
    use ApiResponse;
    public function index()
    {

        // return $this->success(Feature::with('plans')->get());
        return $this->success(Feature::with(['plans' => function ($q) {
            $q->select('plan_name', 'access', 'access_value');
        }])->get());
    }
    public function plans()
    {
        // return Plan::with('features')->get();
        return $this->success(Plan::get());
    }
}
