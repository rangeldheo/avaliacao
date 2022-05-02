<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanySearch;
use App\Http\Requests\Company\CompanyStoreRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Company;
use App\Repository\CompanyRepository;
use Illuminate\Support\Facades\Lang;

class CompanyController extends Controller
{

    public function index(CompanySearch $request)
    {
        return ApiResponse::return(
            CompanyRepository::getAllPaginate($request, Company::class)
        );
    }

    public function store(CompanyStoreRequest $request)
    {
        return ApiResponse::return(
            CompanyRepository::store(Company::class, $request),
        );
    }

    public function show(Company $company)
    {
        return ApiResponse::return(
            CompanyRepository::show($company)
        );
    }

    public function update(CompanyUpdateRequest $request, Company $company)
    {
        if (CompanyRepository::update($company, $request)) {
            return ApiResponse::return(
                CompanyRepository::show($company),
                Lang::get('default.success_update'),
            );
        }
    }

    public function destroy(Company $company)
    {
        if (CompanyRepository::destroy($company)) {
            return ApiResponse::return(
                [],
                Lang::get('default.success_delete')
            );
        }
    }
}
