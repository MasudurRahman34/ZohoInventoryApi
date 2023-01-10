<?php
namespace App\Http\Services\V1;

use App\Models\Contact;

class ContactService{


    public function store($item){
        $contact=new Contact();
        $contact->ref_object_key =$item['ref_object_key'];
        // $contact->ref_id =$customer->id;
        $contact->ref_id =$item['ref_id'];
        $contact->salutation =isset($item['salutation']) ?$item['salutation'] : null;
        $contact->first_name =isset($item['first_name']) ? $item['first_name'] : null;
        $contact->last_name =isset($item['last_name'])? $item['last_name'] : null;
        $contact->display_name =isset($item['display_name'])? $item['display_name'] : '';
        $contact->company_name =isset($item['company_name']) ? $item['company_name'] : null;
        $contact->contact_email =isset($item['contact_email'])? $item['contact_email'] : null;
        $contact->contact_work_phone =isset($item['contact_work_phone'])? $item['contact_work_phone'] : null;
        $contact->phone_number_country_code =isset($item['phone_number_country_code']) ? $item['phone_number_country_code'] : null;
        $contact->contact_mobile = isset($item['contact_mobile']) ? $item['contact_mobile'] : null;
        $contact->skype = isset($item['skype']) ? $item['skype'] : null;
        $contact->facebook = isset($item['facebook']) ? $item['facebook'] : null;
        $contact->twitter = isset($item['twitter']) ? $item['twitter'] : null;
        $contact->website = isset($item['website']) ? $item['website'] : null;
        
        $contact->designation = isset($item['designation']) ? $item['designation'] : null;
        $contact->department = isset( $item['department']) ? $item['department'] : null;
        $contact->is_primary_contact = isset($item['is_primary_contact']) ? $item['is_primary_contact']:0;
        $contact->contact_type_id = isset($item['contact_type_id']) ? $item['contact_type_id']:0;
        $contact->save();
        return $contact;
}

    public function update($item, $contact){

         $contactData = [
                'ref_object_key' => $item['ref_object_key'],
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
            $unpdatedContact= $contact->update($contactData);
            return $contact;
        
    }
}
