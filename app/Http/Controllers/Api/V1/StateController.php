<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Location\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    use ApiFilter, ApiResponse;
    public function getStatesBycountry(Request $request, $Iso2)
    {
        try {

            //Check weather filter param is correct
            if ($request->has('filter')) {
                $filters = $request->filter;
                if (!array_key_exists('country_iso2', $filters)) {
                    return $this->dataNotFound();
                }
            }

            $query = State::select('id', 'country_iso2', 'country_iso3', 'state_name', 'state_slug');
            $this->filterBy($request, $query);
            $states = $this->query->get();

            if (count($states) > 0) {
                return $this->success($states);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
}
