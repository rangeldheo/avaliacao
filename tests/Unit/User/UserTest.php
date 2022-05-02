<?php

namespace Tests\Unit\User;

use App\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    public $user;
    public $tokenJwt;
    public $endpoint = 'api/v1/user';

    public function boot()
    {
        $this->user = factory(User::class)->create();
        $token = JWTAuth::fromUser($this->user);
        $this->tokenJwt = ['Authorization' => "Bearer {$token}"];
    }

    /** @test */
    public function user_index()
    {
        $this->boot();
        factory(User::class, 2)->create();

        $response = $this->json('GET', $this->endpoint, [], $this->tokenJwt);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        [
                            'id',
                            'name',
                            'email',
                            'email_verified_at',
                            'created_at',
                            'updated_at',
                            'type',
                            'type_name',
                        ],
                        [
                            'id',
                            'name',
                            'email',
                            'email_verified_at',
                            'created_at',
                            'updated_at',
                            'type',
                            'type_name',
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function user_store()
    {
        $this->withoutExceptionHandling();
        $user = [
            'name' => 'Usuário de teste',
            'email' => 'rangeldheo@gmail2.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->json('POST', $this->endpoint, $user);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'type',
                    'type_name',
                ]
            ]);
    }

    /** @test */
    public function user_not_store()
    {
        $user = [];
        $response = $this->json('POST', $this->endpoint, $user);
        $response->assertStatus(422)
            ->assertJsonStructure([
                'data' => [],
                'error' => [
                    'list',
                    'sent_api'
                ]
            ]);
    }

    /** @test */
    public function user_update()
    {
        $this->boot();
        $this->withoutExceptionHandling();

        $dataForUpdate = [
            'name'  => 'Outro nome',
            'email' => 'outroemail@gmail.com',
        ];

        $response = $this->json(
            'PUT',
            "{$this->endpoint}/{$this->user->id}",
            $dataForUpdate,
            $this->tokenJwt
        );
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'type',
                    'type_name',
                ]
            ]);
    }

    /** @test */
    public function user_delete()
    {
        $this->boot();

        $response = $this->json(
            'DELETE',
            "{$this->endpoint}/{$this->user->id}",
            [],
            $this->tokenJwt
        );

        $response->assertStatus(200);
    }
}