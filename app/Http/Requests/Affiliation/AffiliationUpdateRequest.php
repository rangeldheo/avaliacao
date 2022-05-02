<?php

namespace App\Http\Requests\Affiliation;

use Illuminate\Foundation\Http\FormRequest;

class AffiliationUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'approval_affiliation' => 'required|boolean'
        ];
    }
}
