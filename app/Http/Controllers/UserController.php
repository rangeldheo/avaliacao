<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserSearch;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Repository\UserRepository;
use App\User;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    public function index(UserSearch $request)
    {
        return ApiResponse::return(
            UserRepository::getAllPaginate($request, User::class)
        );
    }

    public function store(UserStoreRequest $request)
    {
        return ApiResponse::return(
            UserRepository::store(User::class, $request),
        );
    }

    public function show(User $user)
    {
        return ApiResponse::return(
            UserRepository::show($user)
        );
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        if (UserRepository::update($user, $request)) {
            return ApiResponse::return(
                UserRepository::show($user),
                Lang::get('default.success_update'),
            );
        }
    }

    public function destroy(User $user)
    {
        if (UserRepository::destroy($user)) {
            return ApiResponse::return(
                [],
                Lang::get('default.success_delete')
            );
        }
    }
}
