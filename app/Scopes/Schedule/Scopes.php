<?php

namespace App\Scopes\Schedule;

use App\Alias\ScheduleAlias;
use App\Enums\ScheduleStatus;

/**
 * Agrupa os escopos de queries dos Agendamentos
 */
trait Scopes
{
    public function scopeScheduled($query)
    {
        return $query->where(ScheduleAlias::STATUS, ScheduleStatus::SCHEDULED);
    }

    public function scopeAnswering($query)
    {
        return $query->where(ScheduleAlias::STATUS, ScheduleStatus::ANSWERING);
    }

    public function scopeCanceled($query)
    {
        return $query->where(ScheduleAlias::STATUS, ScheduleStatus::CANCELED);
    }

    public function scopeRescheduled($query)
    {
        return $query->where(ScheduleAlias::STATUS, ScheduleStatus::RESCHEDULED);
    }

    public function scopeCompleted($query)
    {
        return $query->where(ScheduleAlias::STATUS, ScheduleStatus::COMPLETED);
    }
}