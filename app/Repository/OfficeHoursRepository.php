<?php

namespace App\Repository;

use App\Abstracts\RespositoryAbstract;
use App\Models\OfficeHours;
use App\Services\UserServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfficeHoursRepository extends RespositoryAbstract
{
    /**
     * Verifica se o profissional informado já possue o dia da semana
     * configurado. É considerado um dia já configurado se o valor numerico
     * referente ao dia da semana [0,6] está cadastrado na coluna week_day
     * junto com o id do profissional na coluna professional_id
     *
     * @param string $professional_id
     * @param integer $week_day
     * @return boolean
     */
    public static function hasWeekDayConfigured(
        string $professional_id,
        int $week_day
    ): bool {
        $hasWeekDayConfigured = OfficeHours::where([
            ['professional_id', $professional_id],
            ['week_day', $week_day],
        ])->count();

        if ($hasWeekDayConfigured) {
            return true;
        }
        return false;
    }

    /**
     * Remove o horário de intervalo
     *
     * @param OfficeHours $officehour
     * @param Request $request
     * @return boolean
     */
    public static function removeInterval(
        OfficeHours $officehour,
        Request $request
    ): bool {
        $hasNotInterval = $request->get('not_interval');
        if ($hasNotInterval) {
            $officehour->fill([
                'start_interval' => null,
                'end_interval'  => null
            ]);
        }
        return $officehour->update();
    }

    /**
     * Valida se o horário selecionado para o agendamento do serviço
     * está dentro do horário de atendimento configurado pelo profissional
     * inclusive se está fora do horário de almoço/intervalo
     *
     * @return bool
     */
    public static function isValidOfficeHours(): bool
    {
        $professional_id = request()->get('professional_id');
        $startService = new Carbon(request()->get('start_service'));
        $endService = new Carbon(request()->get('end_service'));

        $itIsSameDay = $startService->dayOfWeek == $endService->dayOfWeek;
        if (!$itIsSameDay) {
            return false;
        }

        $startOneMoreMinute = $startService->addMinute()->format('H:i:s');
        $endOneMinuteLess   = $endService->subMinute()->format('H:i:s');

        $hasOfficeHours = OfficeHours::where([
            ['week_day', $startService->dayOfWeek],
            ['professional_id', $professional_id]
        ])
            ->where([
                ['start', '<=', $startOneMoreMinute],
                ['end', '>=', $endOneMinuteLess],
            ])
            ->first();

        return empty($hasOfficeHours)
            ? false
            : self::isOutSideInterval(
                $hasOfficeHours,
                $startOneMoreMinute,
                $endOneMinuteLess
            );
    }

    /**
     * Verifica se o horário selecionado para o agendamento do serviço
     * está dentro do horário de almoço/intervalo
     *
     * @param object $officehour
     * @param string $startOneMoreMinute
     * @param string $endOneMinuteLess
     * @return boolean
     */
    public static function isOutSideInterval(
        object $officehour,
        string $startOneMoreMinute,
        string $endOneMinuteLess
    ): bool {
        $hasNotInterval = empty($officehour->start_interval);

        if ($hasNotInterval) {
            return true;
        }

        $hasInterval = OfficeHours::find($officehour->id)
            ->orWhereBetween('start_interval', [$startOneMoreMinute, $endOneMinuteLess])
            ->orWhereBetween('end_interval', [$startOneMoreMinute, $endOneMinuteLess])
            ->first();

        return $hasInterval ? false : true;
    }
}
