<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use ApiResponse, ApiFilter;
}
