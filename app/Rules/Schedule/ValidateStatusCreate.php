<?php

namespace App\Rules\Schedule;

use App\Alias\ScheduleAlias;
use App\Enums\ScheduleStatus;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class ValidateStatusCreate implements Rule
{
    private string $status_error_label;

    public function __construct()
    {
        $this->status_error_label =
            ScheduleStatus::getDescription(ScheduleStatus::UNKNOWN);
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
        $actualStatus = request()->get(ScheduleAlias::STATUS);

        $isScheduledStatus = $actualStatus == ScheduleStatus::SCHEDULED;

        if ($isScheduledStatus) {
            return true;
        }
        $this->status_error_label =
            ScheduleStatus::getDescription($actualStatus);

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  Lang::get('default.schedule_status_error') .
            $this->status_error_label;
    }
}