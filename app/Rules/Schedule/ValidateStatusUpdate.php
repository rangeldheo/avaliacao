<?php

namespace App\Rules\Schedule;

use App\Alias\ScheduleAlias;
use App\Enums\ScheduleStatus;
use App\Services\ScheduleAutomatoService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateStatusUpdate implements Rule
{
    private FormRequest $request;

    private string $status_error_label;
    private string $status_actual;

    public function __construct(FormRequest $request)
    {
        $this->request = $request;
        $this->status_error_label =  ScheduleStatus::getDescription(-1);
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
        $input = $this->request->all();

        $isValidStatus = ScheduleAutomatoService::validateStatus(
            $this->request->schedule->status,
            $input[ScheduleAlias::STATUS]
        );

        if ($isValidStatus) {
            return true;
        }

        $this->status_error_label =
            ScheduleStatus::getDescription($input[ScheduleAlias::STATUS]);

        $this->status_actual =
            ScheduleStatus::getDescription($this->request->schedule->status);
        $input[ScheduleAlias::STATUS] = -1;  //força o erro na validação

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Não é possível alterar o status de {$this->status_actual} para {$this->status_error_label}";
    }
}