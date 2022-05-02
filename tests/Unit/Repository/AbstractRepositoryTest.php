<?php

namespace Tests\Unit\Repository;

use App\Http\Requests\User\UserSearch;
use App\Repository\UserRepository;
use App\Services\SearchServices;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AbstractRepositoryTest extends TestCase
{
    public function boot()
    {
        $this->user = factory(User::class)->create();
        $token = JWTAuth::fromUser($this->user);
        $this->tokenJwt = ['Authorization' => "Bearer {$token}"];
    }

    /** @test*/
    public function get_all_paginate()
    {
        $this->withoutExceptionHandling();
        $this->boot();

        $qtyUserToCreate = 9;
        factory(User::class, $qtyUserToCreate)->create();

        $request = new UserSearch(
            [
                SearchServices::RESULTS => 5
            ]
        );

        $response = UserRepository::getAllPaginate($request, User::class);
        $this->assertEquals(true, $response instanceof LengthAwarePaginator);
        $this->assertEquals($response->total(), 10);
        $this->assertEquals($response->perPage(), 5);
    }
}
