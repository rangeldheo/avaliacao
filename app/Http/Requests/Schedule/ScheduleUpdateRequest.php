<?php

namespace App\Http\Requests\Schedule;

use App\Enums\ScheduleStatus;
use App\Rules\Schedule\ValidateStatusUpdate;
use App\Services\ScheduleAutomatoService;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
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
            'real_start_service' => 'sometimes|date|after:now|date_format:aaaa-mm-dd H:m:s',
            'real_end_service'   => 'sometimes|date|after:real_start_service',
            'status'             => ['sometimes', 'numeric', new ValidateStatusUpdate($this)]
        ];
    }
}