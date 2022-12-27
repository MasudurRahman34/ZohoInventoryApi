<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\Collections\ContactCollection;
use App\Http\Resources\v1\ContactResource;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    use ApiFilter, ApiResponse;

    public function index(Request $request)
    { //return $request;
        $this->setFilterProperty($request);
        $query = Contact::where('account_id', $this->account_id);
        $this->dateRangeQuery($request, $query, 'created_at');
        $contacts= $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new ContactCollection($contacts));
    }
    public function show($id)
    {
        $contact = Contact::where('account_id', Auth::user()->account_id)->find($id);
        if($contact){
            return $this->success(new ContactResource($contact));
        }else{
            return $this->error('Data Not Found',404);
        } 
    }
    public function create(ContactRequest $request)
    {

        $item = $request->all();
        if ($request['source'] === 'supplier') {
            $ref_object_key = Address::$ref_supplier_key;
        } elseif ($request['source'] === 'customer') {
            $ref_object_key = Address::$ref_customer_key;
        } elseif ($request['source'] === 'user') {
            $ref_object_key = Address::$ref_user_key;
        } else {
            $message['source'][] = "The source value deos not match.";
            return $this->error($message, 422);
        }

        $ContactData = [
            'ref_object_key' => $ref_object_key,
            'ref_id' => $request->ref_id,
            'salutation' => isset($item['salutation']) ? $item['salutation'] : null,
            'first_name' => isset($item['first_name']) ? $item['first_name'] : null,
            'last_name' => isset($item['last_name']) ? $item['last_name'] : null,
            'display_name' => isset($item['display_name']) ? $item['display_name'] : '',
            'company_name' => isset($item['company_name']) ? $item['company_name'] : null,
            'contact_email' => isset($item['contact_email']) ? $item['contact_email'] : null,
            'contact_work_phone' => isset($item['contact_work_phone']) ? $item['contact_work_phone'] : null,
            'phone_number_country_code' => isset($item['phone_number_country_code']) ? $item['phone_number_country_code'] : null,
            'contact_mobile' => isset($item['contact_mobile']) ? $item['contact_mobile'] : null,
            'skype' => isset($item['skype']) ? $item['skype'] : null,
            'facebook' => isset($item['facebook']) ? $item['facebook'] : null,
            'twitter' => isset($item['twitter']) ? $item['twitter'] : null,
            'website' => isset($item['website']) ? $item['website'] : null,

            'designation' => isset($item['designation']) ? $item['designation'] : null,
            'department' => isset($item['department']) ? $item['department'] : null,
            'is_primary_contact' => isset($item['is_primary_contact']) ? $item['is_primary_contact'] : 0,
            'contact_type_id' => isset($item['contact_type_id']) ? $item['contact_type_id'] : 0,
            'modified_by' =>Auth::user()->id,
        ];

        DB::beginTransaction();
        try {

            $contact = Contact::create($ContactData);

            DB::commit();
            return $this->success(new ContactResource($contact), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
        }
    }
    public function update(ContactRequest $request, $contact_id)
    {
        $contact = Contact::where('account_id', Auth::user()->account_id)->find($contact_id);
        if ($contact) {
            if ($request['source'] == 'supplier') {
                $ref_object_key = Address::$ref_supplier_key;
            } elseif ($request['source'] == 'customer') {
                $ref_object_key = Address::$ref_customer_key;
            } elseif ($request['source'] == 'user') {
                $ref_object_key = Address::$ref_user_key;
            } else {
                $message['source'][] = "The source value deos not match.";
                return $this->error($message, 422);
            }
            $item = $request->all();
            $contactData = [
                'ref_object_key' => $ref_object_key,
                'ref_id' => isset($item['ref_id']) ? $item['ref_id'] : $contact->ref_id,
                'salutation' => isset($item['salutation']) ? $item['salutation'] : $contact->salutation,
                'first_name' => isset($item['first_name']) ? $item['first_name'] : $contact->first_name,
                'last_name' => isset($item['last_name']) ? $item['last_name'] : $contact->last_name,
                'display_name' => isset($item['display_name']) ? $item['display_name'] : $contact->display_name,
                'company_name' => isset($item['company_name']) ? $item['company_name'] : $contact->company_name,
                'contact_email' => isset($item['contact_email']) ? $item['contact_email'] : $contact->contact_email,
                'contact_work_phone' => isset($item['contact_work_phone']) ? $item['contact_work_phone'] : $contact->contact_work_phone,
                'phone_number_country_code' => isset($item['phone_number_country_code']) ? $item['phone_number_country_code'] : $contact->phone_number_country_code,
                'contact_mobile' => isset($item['contact_mobile']) ? $item['contact_mobile'] : $contact->contact_mobile,
                'skype' => isset($item['skype']) ? $item['skype'] : $contact->skype,
                'facebook' => isset($item['facebook']) ? $item['facebook'] : $contact->facebook,
                'twitter' => isset($item['twitter']) ? $item['twitter'] : $contact->twitter,
                'website' => isset($item['website']) ? $item['website'] : $contact->website,

                'designation' => isset($item['designation']) ? $item['designation'] : $contact->designation,
                'department' => isset($item['department']) ? $item['department'] : $contact->department,
                'is_primary_contact' => isset($item['is_primary_contact']) ? $item['is_primary_contact'] : $contact->is_primary_contact,
                'contact_type_id' => isset($item['contact_type_id']) ? $item['contact_type_id'] : $contact->contact_type_id,
            ];

            try {
                DB::beginTransaction();
                $contact->update($contactData);
                DB::commit();
                return $this->success(new ContactResource($contact));
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
            }
        } else {
            return $this->error("Data Not Found", 200);
        }
    }

    public function delete($id)
    {
        $contact=Contact::where('account_id', Auth::user()->account_id)->find($id);
        if($contact){
            $contact->destroy($id);
            return $this->success(null,200);
        }else{
            return $this->error('Data Not Found',200);
        };
    }
}
