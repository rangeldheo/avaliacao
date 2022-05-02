<?php

namespace App\Http\Requests\Category;

use App\Services\SearchServices;
use Illuminate\Foundation\Http\FormRequest;

class CategorySearch extends FormRequest
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
            'title'=>'sometimes|min:3',
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
