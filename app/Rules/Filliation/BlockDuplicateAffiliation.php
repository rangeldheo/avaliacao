<?php

namespace App\Rules\Filliation;

use App\Repository\AffiliationRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class BlockDuplicateAffiliation implements Rule
{
    /**
     * @var FormRequest
     */
    private FormRequest $request;

    public function __construct(FormRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $fields = $this->request->all();

        $haveAnyEmptyFields =
            empty($fields['professional_id']) ||
            empty($fields['company_id']);

        if ($haveAnyEmptyFields) {
            return false;
        }

        $canCreateAffiliation = !AffiliationRepository::isDuplicate(
            $fields['professional_id'],
            $fields['company_id']
        );

        return $canCreateAffiliation;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('default.affiliation_is_duplicate');
    }
}