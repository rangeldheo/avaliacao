<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeHours\OfficeHoursSearch;
use App\Http\Requests\OfficeHours\OfficeHoursStoreRequest;
use App\Http\Requests\OfficeHours\OfficeHoursUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\OfficeHours;
use App\Repository\OfficeHoursRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class OfficeHoursController extends Controller
{
    public function index(OfficeHoursSearch $request)
    {
        return ApiResponse::return(
            OfficeHoursRepository::getAllPaginate($request, OfficeHours::class)
        );
    }

    public function store(OfficeHoursStoreRequest $request)
    {
        return ApiResponse::return(
            OfficeHoursRepository::store(OfficeHours::class, $request),
        );
    }

    public function update(OfficeHoursUpdateRequest $request, OfficeHours $officehour)
    {
        if (OfficeHoursRepository::update($officehour, $request)) {
            return ApiResponse::return(
                OfficeHoursRepository::show($officehour),
                Lang::get('default.success_update'),
            );
        }
    }

    public function removeInterval(Request $request, OfficeHours $officehour)
    {
        if (OfficeHoursRepository::removeInterval($officehour, $request)) {
            return ApiResponse::return(
                OfficeHoursRepository::show($officehour),
                Lang::get('default.success_update'),
            );
        }
    }
}