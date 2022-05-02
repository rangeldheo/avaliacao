<?php

namespace Tests\Unit\Repository;

use App\Enums\Status;
use App\Http\Controllers\Auth\AuthController;
use App\Repository\UserRepository;
use App\User;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public $user;
    public $endpoint = 'api/v1/auth/login';
    public $endpointLogout = 'api/v1/auth/logout';

    public function boot()
    {
        $this->user = factory(User::class)->create();
        $this->user->status = Status::ACTIVE;
        $this->user->update();
    }


    /** @test */
    public function is_update_first_login_to_false_e2e()
    {
        $this->boot();

        $dataToLogin = [
            'email' => $this->user->email,
            'password' => '12345678'
        ];

        $execFirstLogin = $this->json('POST', $this->endpoint, $dataToLogin);
        $execFirstLogin->assertStatus(200);

        $execLogout =  $this->json('POST', $this->endpointLogout);
        $execLogout->assertStatus(200);

        $execSecondLogin = $this->json('POST', $this->endpoint, $dataToLogin);
        $execSecondLogin->assertStatus(200);

        $userRefresh = User::first();
        $this->assertEquals(false, $userRefresh->first_login);
    }

    /** @test */
    public function is_update_first_login_to_false()
    {
        $this->boot();

        $credentials = [
            'email' => $this->user->email,
            'password' => '12345678'
        ];

        $authController = new AuthController();
        $authController->guard('api')->attempt($credentials);
        $this->assertEquals(true, $this->user->first_login);

        UserRepository::updateFirstLogin();

        $userRefresh = User::first();
        $this->assertEquals(false, $userRefresh->first_login);
    }
}