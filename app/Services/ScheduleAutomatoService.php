<?php

namespace App\Services;

use App\Enums\ScheduleStatus;

/**
 * Classe de gestão de status automato
 * Que impede a alteração aleatória do
 * Status dos agendamentos
 */
class ScheduleAutomatoService
{
    /**
     * Impede que o status do agendamento
     * seja modificado aleatoriamente
     *
     * @param int $actualStatus
     * @param int $nestStatusAllowed
     *
     * @return Bool
     */
    public static function validateStatus(
        int $actualStatus,
        int $nestStatusAllowed
    ): Bool {
        if ($actualStatus == ScheduleStatus::SCHEDULED) {
            return in_array($nestStatusAllowed, [
                ScheduleStatus::SCHEDULED,
                ScheduleStatus::ANSWERING,
                ScheduleStatus::CANCELED,
                ScheduleStatus::RESCHEDULED
            ]);
        }

        if ($actualStatus == ScheduleStatus::ANSWERING) {
            return in_array($nestStatusAllowed, [
                ScheduleStatus::ANSWERING,
                ScheduleStatus::CANCELED,
                ScheduleStatus::RESCHEDULED,
                ScheduleStatus::COMPLETED
            ]);
        }

        if ($actualStatus == ScheduleStatus::CANCELED) {
            return in_array($nestStatusAllowed, [ScheduleStatus::CANCELED]);
        }

        if ($actualStatus == ScheduleStatus::RESCHEDULED) {
            return in_array($nestStatusAllowed, [
                ScheduleStatus::ANSWERING,
                ScheduleStatus::CANCELED,
                ScheduleStatus::RESCHEDULED
            ]);
        }

        if ($actualStatus == ScheduleStatus::COMPLETED) {
            return in_array($nestStatusAllowed, [ScheduleStatus::COMPLETED]);
        }

        return false;
    }
}