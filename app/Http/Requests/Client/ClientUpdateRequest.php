<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            'document'     => 'sometimes|cpf|unique:clients,document,' . $this->client->id,
            'mobile_phone' => 'sometimes|celular_com_ddd|unique:clients,mobile_phone,' . $this->client->id,
            'nickname'     => 'sometimes|min:3|max:80',
            'company_id'   => 'sometimes|exists:clients,id',
            'zipcode'      => 'sometimes',
            'street'       => 'sometimes',
            'number'       => 'sometimes',
            'district'     => 'sometimes',
            'city'         => 'sometimes',
            'state'        => 'sometimes'
        ];
    }
}
