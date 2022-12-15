<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEventRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'age_limit' => ['required', 'string'],
            'desc' => ['string','nullable'],
            'image' => ['string','nullable'],
            'cover' => ['string','nullable'],
            'meta_title' => ['required','string'],
            'meta_keywords' => ['required','string'],
            'meta_desc' => ['required','string'],
            'status' => ['required','numeric'],
        ];
    }
}
