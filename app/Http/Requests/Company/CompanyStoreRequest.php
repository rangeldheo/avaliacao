<?php

namespace App\Http\Requests\Company;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'corporate_name' => 'required|string|max:255',
            'corporate_doc' => 'required|cnpj|unique:companies,corporate_doc',
            'manager' => 'required',
            'mobile_phone' => 'required|celular_com_ddd|unique:companies,mobile_phone',
            'web_site' => 'sometimes|url',
            'zipcode' => 'required',
            'street' => 'required',
            'number' => 'required',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required'
        ];
    }

    /**
     * Atens de passar pelos filtros de validação
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

        $input = $this->input();

        if (!$this->has('country')) {
            $input['country'] = 'Brasil';
        }

        $this->replace($input);
    }
}
