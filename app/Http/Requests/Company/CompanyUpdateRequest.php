<?php

namespace App\Http\Requests\Company;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'corporate_name' => 'sometimes|string|max:255',
            'corporate_doc' => 'sometimes|cnpj|unique:companies,corporate_doc,' . $this->company->id,
            'manager' => 'sometimes',
            'mobile_phone' => 'sometimes|celular_com_ddd|unique:companies,mobile_phone,' . $this->company->id,
            'web_site' => 'sometimes|url',
            'zipcode' => 'sometimes',
            'street' => 'sometimes',
            'number' => 'sometimes',
            'district' => 'sometimes',
            'city' => 'sometimes',
            'state' => 'sometimes'
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
        //
    }
}
