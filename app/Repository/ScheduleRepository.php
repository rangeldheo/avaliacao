<?php

namespace App\Repository;

use App\Abstracts\RespositoryAbstract;
use App\Enums\ScheduleStatus;
use App\Models\Schedule;

/**
 * [Repositorio para agendamentos]
 */
class ScheduleRepository extends RespositoryAbstract
{
    /**
     * Verifica se o agendamento que está sendo inserido na base de dados
     * está duplicado
     * @return bool
     */
    public static function isDuplicate(): bool
    {
        $professional_id =  request()->get('professional_id');
        $client_id       =  request()->get('client_id');
        $start_service   =  request()->get('start_service');
        $end_service     =  request()->get('end_service');

        $Schedule = new Schedule();
        $hasSchedulesDuplicates = $Schedule->where([
            ['professional_id', $professional_id],
            ['client_id', $client_id],
            ['status', ScheduleStatus::SCHEDULED]
        ])
            ->WhereBetween('start_service', [$start_service, $end_service])
            ->orWhereBetween('end_service', [$start_service, $end_service])
            ->count();

        return $hasSchedulesDuplicates ? true : false;
    }
}
