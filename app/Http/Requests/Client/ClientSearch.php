<?php

namespace App\Http\Requests\Client;

use App\Alias\ScheduleAlias;
use App\Services\AdjustRequestSchedule;
use App\Services\SearchServices;
use Illuminate\Foundation\Http\FormRequest;

class ClientSearch extends FormRequest
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
            'status'   => 'sometimes|numeric',
            'user_id'  => 'sometimes|numeric',
            'document' => 'sometimes|min:3',
            'nickname' => 'sometimes|min:3',
            'mobile_phone' => 'sometimes',
            'city' => 'sometimes|min:3',
            'state' => 'sometimes|min:2',
            'district' => 'sometimes|min:3',
            'country' => 'sometimes|min:3',
            'results' => 'numeric',
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->input();

        /*
        |-----------------------------------------------------------------------
        | Se o campo results não estiver definido na request, consideramos que a
        | quantidade de resultados retornados por página será 20
        |-----------------------------------------------------------------------
        */
        if (!$this->has(SearchServices::RESULTS)) {
            $input[SearchServices::RESULTS] = 20;
        }

        $this->replace($input);
    }
}