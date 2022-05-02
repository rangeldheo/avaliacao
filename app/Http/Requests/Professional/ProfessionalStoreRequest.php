<?php

namespace App\Http\Requests\Professional;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class ProfessionalStoreRequest extends FormRequest
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
            'document' => 'required|cpf|unique:professionals,document',
            'mobile_phone' => 'required|celular_com_ddd|unique:professionals,mobile_phone',
            'nickname' => 'required|min:3|max:80',
            'company_id' => 'required|exists:companies,id',
            'zipcode' => 'required',
            'street' => 'required',
            'number' => 'required',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required',
            'products.*' => 'sometimes|exists:products,id'
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
