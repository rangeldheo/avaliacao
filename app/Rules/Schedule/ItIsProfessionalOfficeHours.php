<?php

namespace App\Rules\Schedule;

use App\Repository\OfficeHoursRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

/**
 * Verifica se o agendamento está dentro de um dia e hoarário
 * configurado no OfficeHours do profissional
 */
class ItIsProfessionalOfficeHours implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return OfficeHoursRepository::isValidOfficeHours();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('default.invalid_office_hours');
    }
}