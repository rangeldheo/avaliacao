<?php

namespace App\Http\Controllers;

use App\Abstracts\RespositoryAbstract;
use App\Http\Requests\Client\ClientSearch;
use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Client;
use App\Repository\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ClientController extends Controller
{
    public function index(ClientSearch $request)
    {
        return ApiResponse::return(
            ClientRepository::getAllPaginate($request, Client::class)
        );
    }

    public function store(ClientStoreRequest $request)
    {
        return ApiResponse::return(
            ClientRepository::store(Client::class, $request),
        );
    }

    public function show(Client $client)
    {
        return ApiResponse::return(
            ClientRepository::show($client)
        );
    }

    public function update(ClientUpdateRequest $request, Client $client)
    {
        if (ClientRepository::update($client, $request)) {
            return ApiResponse::return(
                ClientRepository::show($client),
                Lang::get('default.success_update'),
            );
        }
    }

    public function destroy(Client $client)
    {
        if (ClientRepository::destroy($client)) {
            return ApiResponse::return(
                [],
                Lang::get('default.success_delete')
            );
        }
    }
}