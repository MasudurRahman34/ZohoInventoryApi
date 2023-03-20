<?php

namespace App\Http\Services\V1;

use App\Models\Address;
use App\Models\Country;
use App\Models\GlobalAddress;
use App\Models\Location\District;
use App\Models\Location\State;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;


class AddressService
{

    public function store($item)
    {
        $address = new Address();
        $address->ref_object_key = $item['ref_object_key'];
        $address->ref_id = $item['ref_id'];
        $address->attention = isset($item['attention']) ? $item['attention'] : null;
        $address->country_id = isset($item['country_id']) ? $item['country_id'] : 0;
        $address->state_id = isset($item['state_id']) ? $item['state_id'] : 0;
        $address->district_id = isset($item['district_id']) ? $item['district_id'] : 0;
        $address->thana_id = isset($item['thana_id']) ? $item['thana_id'] : 0;
        $address->union_id = isset($item['union_id']) ? $item['union_id'] : 0;
        $address->zipcode_id = isset($item['zipcode_id']) ? $item['zipcode_id'] : 0;
        $address->street_address_id = isset($item['street_address_id']) ? $item['street_address_id'] : 0;
        $address->house = isset($item['house']) ? $item['house'] : 0;
        $address->phone = isset($item['phone']) ? $item['phone'] : 0;
        $address->fax = isset($item['fax']) ? $item['fax'] : 0;
        $address->is_bill_address = isset($item['is_bill_address']) ? $item['is_bill_address'] : 0;
        $address->is_ship_address = isset($item['is_ship_address']) ? $item['is_ship_address'] : 0;
        $address->status = isset($item['status']) ? $item['status'] : 1;
        $address->full_address = $this->setAddress($item);
        $address->save();

        //insert global address if not exist.
        $globalAddress = $this->storeGlobalAddress($address);

        return $address;
    }
    public function update($request, $address)
    {

        $address_data = [
            'ref_object_key' => $request->ref_object_key,
            'ref_id' => isset($request->ref_id) ? $request->ref_id : $address->ref_id,
            'attention' => isset($request->attention) ? $request->attention : $address->attention,
            'country_id' => isset($request->country_id) ? $request->country_id : $address->country_id,
            'state_id' => isset($request->state_id) ? $request->state_id : $address->state_id,
            'district_id' => isset($request->district_id) ? $request->district_id : $address->district_id,
            'thana_id' => isset($request->thana_id) ? $request->thana_id : $address->thana_id,
            'union_id' => isset($request->union_id) ? $request->union_id  : $address->union_id,
            'zipcode_id' => isset($request->zipcode_id) ? $request->zipcode_id : $address->zipcode_id,
            'street_address_id' => isset($request->street_address_id) ? $request->street_address_id  : $address->street_address_id,
            'house' => isset($request->house) ? $request->house : $address->house,
            'phone' => isset($request->phone)  ? $request->phone : $address->phone,
            'fax' => isset($request->fax) ? $request->fax : $address->fax,
            'is_bill_address' => isset($request->is_bill_address) ? $request->is_bill_address : $address->is_bill_address,
            'is_ship_address' => isset($request->is_ship_address) ? $request->is_ship_address : $address->is_ship_address,
            'status' => isset($request->status) ? $request->status : $address->status,

        ];
        $address_data['full_address'] = $this->setAddress($address);
        //return $address;
        $updatedAddress = $address->update($address_data);
        $globalAddress = $this->storeGlobalAddress($address);
        return $updatedAddress;
    }
    public function delete()
    {
    }

    public function setAddress($request)
    {
        //$add=Country::where('id',$request['country_id'])->select('id','countryName')->get();
        //return print_r($add);

        $address['country'] = Country::where('id', $request['country_id'])->select('id', 'country_name')->first();
        $address['state'] = State::where('id', $request['state_id'])->select('id', 'state_name')->first();
        $address['district'] = District::where('id', $request['district_id'])->select('id', 'district_name')->first();
        $address['thana'] = Thana::where('id', $request['thana_id'])->select('id', 'thana_name')->first();
        $address['union'] = Union::where('id', $request['union_id'])->select('id', 'union_name')->first();
        $address['zipcode'] = Zipcode::where('id', $request['zipcode_id'])->select('id', 'zip_code')->first();
        $address['street_address'] = StreetAddress::where('id', $request['street_address_id'])->select('id', 'street_address_value')->first();
        //dd($address);
        return $address;
    }

    public function setPlainAddress($fullAddress)
    {
        $plainAddress = $fullAddress['street_address']['street_address_value'] . '-' . $fullAddress['zipcode']['zip_code'] . ', ' . $fullAddress['union']['union_name'] . ', ' . $fullAddress['thana']['thana_name'] . ', ' . $fullAddress['district']['district_name'] . ', ' . $fullAddress['country']['country_name'];
        return  $plainAddress;
    }

    public function storeGlobalAddress($address)
    {
        $is_find_global_address = GlobalAddress::where('full_address', json_encode($address->full_address))->first();
        if (!$is_find_global_address) {
            $globalAddress = new GlobalAddress();
            $globalAddress->country_id = $address->country_id;
            $globalAddress->state_id = $address->state_id;
            $globalAddress->district_id = $address->district_id;
            $globalAddress->thana_id = $address->thana_id;
            $globalAddress->union_id = $address->union_id;
            $globalAddress->zipcode_id = $address->zipcode_id;
            $globalAddress->street_address_id = $address->street_address_id;
            $globalAddress->full_address = $address->full_address;
            $globalAddress->plain_address = $this->setPlainAddress($address->full_address);
            $globalAddress->status = 1;
            $globalAddress->save();
            return $globalAddress;
        } else {
            return $address;
        }
    }
}
