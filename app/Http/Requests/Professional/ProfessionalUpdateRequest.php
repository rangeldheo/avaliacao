<?php

namespace App\Http\Requests\Professional;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class ProfessionalUpdateRequest extends FormRequest
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
            'document' => 'sometimes|cpf|unique:professionals,document,' . $this->professional->id,
            'mobile_phone' => 'sometimes|celular_com_ddd|unique:professionals,mobile_phone,' . $this->professional->id,
            'nickname' => 'sometimes|min:3|max:80',
            'company_id' => 'sometimes|exists:companies,id',
            'zipcode' => 'sometimes',
            'street' => 'sometimes',
            'number' => 'sometimes',
            'district' => 'sometimes',
            'city' => 'sometimes',
            'state' => 'sometimes',
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
    }
}
