<?php

namespace App\Http\Requests\User;

use App\Services\SearchServices;
use Illuminate\Foundation\Http\FormRequest;

class UserSearch extends FormRequest
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
            'results' => 'numeric'
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->input();

        /*
        |---------------------------------------------------------------------------
        | Se o campo results não estiver definido na request, consideramos que a
        | quantidade de resultados retornados por página será 20
        |---------------------------------------------------------------------------
        */
        if (!$this->has(SearchServices::RESULTS)) {
            $input[SearchServices::RESULTS] = 20;
        }

        $this->replace($input);
    }
}
