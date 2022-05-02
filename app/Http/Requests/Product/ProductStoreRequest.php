<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use App\Services\UserServices;
use App\Utils\Format;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:1',
            'commission' => 'required|numeric|min:1',
            'commission_type' => 'required|between:0,1'
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
        $input = $this->input();
        //incluímos o usuário logado nos dados de cadastro

        if (!$this->has('user_id')) {
            $input['user_id'] = UserServices::getUserLogged();
        }

        if (!$this->has('company_id')) {
            $input['company_id'] = UserServices::getUserCompany();
        }

        if ($this->has('price')) {
            $input['price'] = Format::floatNormalize($input['price']);
        }

        if ($this->has('commission') && is_float($this->has('commission'))) {
            $input['commission'] = Format::floatNormalize($input['commission']);
        }

        if (!$this->has('commission_type')) {
            $input['commission_type'] = Product::COMISSION_TYPE_PERCENT;
        }

        $this->replace($input);
    }
}
