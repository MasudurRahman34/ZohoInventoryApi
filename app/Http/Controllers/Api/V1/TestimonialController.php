<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $testimonials = Testimonial::paginate(20);
        return $this->success($testimonials);
    }
}
