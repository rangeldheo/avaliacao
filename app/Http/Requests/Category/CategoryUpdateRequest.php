<?php

namespace App\Http\Requests\Category;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            'title' => 'sometimes|min:3|unique:categories,title,' . $this->category->id,
            'description' => 'sometimes'
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
    }
}
