<?php

namespace Tests\Unit\Auth;

use App\Enums\Status;
use App\User;
use Tests\TestCase;

class UserAuthorizationTest extends TestCase
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
    public function is_login()
    {
        $this->boot();
        $dataToLogin = [
            'email' => $this->user->email,
            'password' => '12345678'
        ];

        $response = $this->json('POST', $this->endpoint, $dataToLogin);
        $response->assertStatus(200);
    }

    /** @test */
    public function not_authorizing_using_incorrect_password()
    {
        $this->boot();
        $dataToLogin = [
            'email' => $this->user->email,
            'password' => 'xxxxxxxx'
        ];

        $unauthorized = 401;

        $response = $this->json('POST', $this->endpoint, $dataToLogin);
        $response->assertStatus($unauthorized);
    }

    /** @test */
    public function not_authorizing_using_incorrect_email()
    {
        $this->boot();
        $dataToLogin = [
            'email' => 'not_email@exemple.com',
            'password' => '12345678'
        ];

        $unauthorized = 401;

        $response = $this->json('POST', $this->endpoint, $dataToLogin);
        $response->assertStatus($unauthorized);
    }

    /** @test */
    public function is_logout()
    {
        $this->boot();
        $dataToLogin = [
            'email' => $this->user->email,
            'password' => '12345678'
        ];

        $response = $this->json('POST', $this->endpoint, $dataToLogin);
        $response->assertStatus(200);

        $response =  $this->json('POST', $this->endpointLogout);
        $response->assertStatus(200);
    }
}