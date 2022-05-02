<?php

namespace App\Utils;

use Illuminate\Support\Facades\Lang;

/**
 * Todas as classes mapeadas aqui
 */
class ModelsGlossary
{
    public static function getName($path)
    {

        $models = [
            'App\Models\Category' => Lang::get('default.models.category'),
            'App\Models\Product' => Lang::get('default.models.product'),
            'App\Models\Company' => Lang::get('default.models.company'),
            'App\Models\Professional' => Lang::get('default.models.professional'),
            'App\Models\Client' => Lang::get('default.models.client'),
            'App\Models\Schedule' => Lang::get('default.models.schedule'),
            'App\Models\OfficeHours' => Lang::get('default.models.office_hours'),
            'App\User' => Lang::get('default.models.user')
        ];
        return ucfirst($models[$path]) ?? null;
    }
}