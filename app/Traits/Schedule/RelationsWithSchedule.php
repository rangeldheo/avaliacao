<?php

namespace App\Traits\Schedule;

use App\Models\Schedule;

/**
 * Agrupa os relacionamentos entre um modelo e o modelo agendamento
 * a classe SCHEDULE
 */
trait RelationsWithSchedule
{
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function schedulesScheduled()
    {
        return $this->hasMany(Schedule::class)
            ->scheduled();
    }

    public function schedulesCanceled()
    {
        return $this->hasMany(Schedule::class)
            ->canceled();
    }

    public function schedulesAnswering()
    {
        return $this->hasMany(Schedule::class)
            ->answering();
    }

    public function schedulesRescheduled()
    {
        return $this->hasMany(Schedule::class)
            ->rescheduled();
    }

    public function schedulesCompleted()
    {
        return $this->hasMany(Schedule::class)
            ->completed();
    }
}