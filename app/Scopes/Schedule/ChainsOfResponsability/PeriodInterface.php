<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use Illuminate\Http\Request;

interface PeriodInterface
{
    public function handler(Request $request);
}