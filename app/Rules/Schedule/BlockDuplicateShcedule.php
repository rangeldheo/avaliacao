<?php

namespace App\Rules\Schedule;

use App\Repository\ScheduleRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class BlockDuplicateShcedule implements Rule
{
    /**
     * Verifica se o agendamento está duplicado
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $canCreateSchedules = !ScheduleRepository::isDuplicate();
        return $canCreateSchedules;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('default.is_duplicate_schedule');
    }
}