<?php

namespace App\Http\Requests\Schedule;

use App\Alias\ScheduleAlias;
use App\Enums\ScheduleStatus;
use App\Rules\Schedule\BlockDuplicateShcedule;
use App\Rules\Schedule\ItIsProfessionalOfficeHours;
use App\Rules\Schedule\ValidateStatusCreate;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
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
            'professional_id'    => 'required|exists:professionals,id',
            'client_id'          => 'required|exists:clients,id',
            'product_id'         => 'required|exists:products,id',
            ScheduleAlias::REAL_START_SERVICE => 'sometimes|date|after:now|date_format:aaaa-mm-dd H:m:s',
            ScheduleAlias::REAL_END_SERVICE   => 'sometimes|date|after:real_start_service',
            ScheduleAlias::END_SERVICE        => 'required|date|after:start',
            ScheduleAlias::START_SERVICE      => [
                'required',
                'date',
                'after:now',
                new BlockDuplicateShcedule,
                new ItIsProfessionalOfficeHours
            ],
            ScheduleAlias::STATUS => ['required', 'numeric', new ValidateStatusCreate],
        ];
    }
}