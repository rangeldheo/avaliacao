<?php

namespace App\Http\Requests\OfficeHours;

use App\Rules\OfficeHours\BlockDuplicateDay;
use Illuminate\Foundation\Http\FormRequest;

class OfficeHoursStoreRequest extends FormRequest
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
            'professional_id' => 'required|exists:professionals,id',
            'week_day'        => [
                'required',
                'integer',
                'between:0,6', new BlockDuplicateDay($this)
            ],
            'start'           => 'required|date_format:H:i',
            'end'             => 'required|date_format:H:i|after:start',
            'start_interval'  => 'sometimes|date_format:H:i',
            'end_interval'    => 'sometimes|date_format:H:i|after:start_interval',
            'status'          => 'between:0,3'
        ];
    }
}