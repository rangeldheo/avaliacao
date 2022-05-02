<?php

namespace App\Http\Controllers;

use App\Http\Requests\Affiliation\AffiliationStoreRequest;
use App\Http\Requests\Affiliation\AffiliationUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Affiliation;
use App\Models\Professional;
use App\Repository\AffiliationRepository;
use Illuminate\Support\Facades\Lang;

class AffiliationController extends Controller
{
    public function store(AffiliationStoreRequest $request)
    {
        return ApiResponse::return(
            AffiliationRepository::store(Affiliation::class, $request),
            Lang::get('default.affilation_success')
        );
    }

    public function update(AffiliationUpdateRequest $request, Affiliation $affiliation)
    {
        if (AffiliationRepository::update($affiliation, $request)) {
            return ApiResponse::return(
                AffiliationRepository::show($affiliation),
                Lang::get('default.success_update'),
            );
        }
    }
}