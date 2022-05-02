<?php

namespace App\Http\Controllers;

use App\Http\Requests\Schedule\ScheduleSearch;
use App\Http\Requests\Schedule\ScheduleStoreRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Schedule;
use App\Repository\ScheduleRepository;
use Illuminate\Support\Facades\Lang;

class ScheduleController extends Controller
{
    public function index(ScheduleSearch $request)
    {
        return ApiResponse::return(
            ScheduleRepository::getAllPaginate($request, Schedule::class)
        );
    }

    public function store(ScheduleStoreRequest $request)
    {
        return ApiResponse::return(
            ScheduleRepository::store(Schedule::class, $request),
        );
    }

    public function show(Schedule $Schedule)
    {
        return ApiResponse::return(
            ScheduleRepository::show($Schedule)
        );
    }

    public function update(ScheduleUpdateRequest $request, Schedule $Schedule)
    {
        if (ScheduleRepository::update($Schedule, $request)) {
            return ApiResponse::return(
                ScheduleRepository::show($Schedule),
                Lang::get('default.success_update'),
            );
        }
    }

    public function destroy(Schedule $Schedule)
    {
        if (ScheduleRepository::destroy($Schedule)) {
            return ApiResponse::return(
                [],
                Lang::get('default.success_delete')
            );
        }
    }
}