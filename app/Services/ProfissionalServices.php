<?php

namespace App\Services;

use App\Models\Professional;

class ProfissionalServices
{
    /**
     * @return string|null
     */
    public static function logged()
    {
        $professionalLogged =
            Professional::where('user_id', auth('api')->user()->id)->get();

        $hasProfessionalLogged =
            !$professionalLogged->isEmpty() && $professionalLogged[0]->id;

        return $hasProfessionalLogged ? $professionalLogged[0]->id : null;
    }
}