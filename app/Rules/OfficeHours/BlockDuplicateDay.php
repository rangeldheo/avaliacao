<?php

namespace App\Rules\OfficeHours;

use App\Enums\DaysOfWeek;
use App\Models\OfficeHours;
use App\Models\Professional;
use App\Repository\OfficeHoursRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class BlockDuplicateDay implements Rule
{
    protected $professional_id;
    protected $week_day;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(FormRequest $request)
    {
        $this->professional_id = $request->get('professional_id');
        $this->week_day = $request->get('week_day');
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
        return !OfficeHoursRepository::hasWeekDayConfigured(
            $this->professional_id,
            $this->week_day
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ucfirst(DaysOfWeek::getDescription($this->week_day)) .
            Lang::get('default.week_day_is_configured');
    }
}