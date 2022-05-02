<?php

namespace Tests\Feature\Autenticacao;

use App\User;
use Tests\TestCase;

class JwtTest extends TestCase
{
    /** @test */
    public function is_autenticate()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $user->status = 1;
        $user->update();

        $response = $this->json('POST', 'api/v1/auth/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'id',
                'type',
                'type_name'
            ]);
    }
}