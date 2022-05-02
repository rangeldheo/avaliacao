<?php

namespace App\Http\Requests\Affiliation;

use App\Rules\Filliation\BlockDuplicateAffiliation;
use App\Rules\Filliation\ProfessionalAlreadyAffiliated;
use App\Services\ProfissionalServices;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AffiliationStoreRequest extends FormRequest
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
            'company_id' => [
                'required',
                'exists:companies,id',
                new BlockDuplicateAffiliation($this),
                new ProfessionalAlreadyAffiliated($this)
            ],
            'professional_id' => 'required|exists:professionals,id',
        ];
    }

    public function prepareForValidation()
    {
        $hasId = ProfissionalServices::logged();

        if ($hasId) {
            $this->merge([
                'professional_id' => $hasId
            ]);
        }

        $this->merge([
            'start_affiliation' => Carbon::now()
        ]);
    }
}