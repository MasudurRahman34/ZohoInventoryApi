<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Resources\v1\Collections\GlobalAddressCollection;
use App\Models\GlobalAddress;

class GlobalAddressController extends Controller
{
    use ApiFilter, ApiResponse;
    public function index(Request $request){
        $this->setFilterProperty($request);
        $query = GlobalAddress::where('deleted_at', NULL);
        if($request->has('plain_address')){
            $query=$query->where('plain_address', 'LIKE', '%' . $request->plain_address . '%');
        }
        //$query = 'GlobalAddress';
        $this->dateRangeQuery($request, $query, 'global_address.created_at');
        $globalAddressses=$this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new GlobalAddressCollection($globalAddressses));
    }
}
