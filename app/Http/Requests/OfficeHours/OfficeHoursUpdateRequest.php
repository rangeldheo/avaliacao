<?php

namespace App\Http\Requests\OfficeHours;

use Illuminate\Foundation\Http\FormRequest;

class OfficeHoursUpdateRequest extends FormRequest
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
            'start'           => 'sometimes|date_format:H:i',
            'end'             => 'sometimes|date_format:H:i|after:start',
            'start_interval'  => 'sometimes|date_format:H:i',
            'end_interval'    => 'sometimes|date_format:H:i|after:start_interval',
            'status'          => 'sometimes|numeric|min:0|max:2'
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->input();

        if ($this->has('professional_id')) {
            unset($input['professional_id']);
        }

        if ($this->has('week_day')) {
            unset($input['week_day']);
        }

        $this->replace($input);
    }
}