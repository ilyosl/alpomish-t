<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationKatokServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'katok_service_id' =>'required',
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'phone'=>'required|string',
            'comment'=>'required|string'
        ];
    }
}
