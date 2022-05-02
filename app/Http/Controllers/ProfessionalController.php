<?php

namespace App\Http\Controllers;

use App\Http\Requests\Professional\ProfessionalSearch;
use App\Http\Requests\Professional\ProfessionalStoreRequest;
use App\Http\Requests\Professional\ProfessionalUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Professional;
use App\Repository\ProfessionalRepository;
use Illuminate\Support\Facades\Lang;

class ProfessionalController extends Controller
{
    public function index(ProfessionalSearch $request)
    {
        return ApiResponse::return(
            ProfessionalRepository::getAllPaginate($request, Professional::class)
        );
    }

    public function store(ProfessionalStoreRequest $request)
    {
        return ApiResponse::return(
            ProfessionalRepository::store(Professional::class, $request),
        );
    }

    public function show(Professional $professional)
    {
        return ApiResponse::return(
            ProfessionalRepository::show($professional)
        );
    }

    public function update(ProfessionalUpdateRequest $request, Professional $professional)
    {
        if (ProfessionalRepository::update($professional, $request)) {
            return ApiResponse::return(
                ProfessionalRepository::show($professional),
                Lang::get('default.success_update'),
            );
        }
    }

    public function destroy(Professional $professional)
    {
        if (ProfessionalRepository::destroy($professional)) {
            return ApiResponse::return(
                [],
                Lang::get('default.success_delete')
            );
        }
    }
}