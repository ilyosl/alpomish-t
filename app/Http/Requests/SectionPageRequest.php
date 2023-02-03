<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionPageRequest extends FormRequest
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
            "name"=>"required",
            "content"=>"string",
            "img_url"=>"mimes:png,jpg,jpeg",
            "images"=> "array"
        ];
    }
}
