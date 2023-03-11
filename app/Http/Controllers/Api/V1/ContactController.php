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
use App\Http\Services\V1\ContactService;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    use ApiFilter, ApiResponse;

    protected $contactService;

    public function __construct(ContactService $contactService)
    {

        $this->contactService= $contactService;
    }

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
        //return $request;


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
        $ContactData = $request->all();
        $ContactData['ref_object_key']=$ref_object_key;


        DB::beginTransaction();
        try {

            //$contact = Contact::create($ContactData);
            $contact = $this->contactService->store($ContactData);

            DB::commit();
            return $this->success(new ContactResource($contact), '', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 422);
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
            $updatedRequest = $request->all();
            $updatedRequest['ref_object_key']=$ref_object_key;

            try {
                DB::beginTransaction();
                // $contact->update($contactData);
                $updatedContact = $this->contactService->update($updatedRequest,$contact);
                DB::commit();
                return $this->success(new ContactResource($updatedContact));
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 422);
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
            return $this->success(null,'',200);
        }else{
            return $this->error('Data Not Found',200);
        };
    }
}
