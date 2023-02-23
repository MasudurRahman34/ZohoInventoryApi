<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'media.file.*' => 'required|file|mimes:png,jpg,jpeg,gif,pdf,exel,docx,doc,txt|max:10240',
            'media.status.*' => 'required|in:0,1',
        ];
    }
}
