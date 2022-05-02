<?php

namespace App\Http\Requests\Client;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'document'     => 'required|cpf|unique:clients,document',
            'mobile_phone' => 'required|celular_com_ddd|unique:clients,mobile_phone',
            'nickname'     => 'required|min:3|max:80',
            'zipcode'      => 'required',
            'street'       => 'required',
            'number'       => 'required',
            'district'     => 'required',
            'city'         => 'required',
            'state'        => 'required'
        ];
    }

    /**
     * Antes de passar pelos filtros de validação
     * acertamos os dados necessários que vem do formulário aqui
     *
     * @return void
     */
    public function prepareForValidation()
    {
        //incluímos o usuário logado nos dados de cadastro
        $this->merge([
            'user_id' => UserServices::getUserLogged()
        ]);
    }
}
