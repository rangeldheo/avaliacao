<?php

namespace Tests\Unit\User;

use App\Enums\Status;
use App\User;
use Tests\TestCase;

class ActivationAccountTest extends TestCase
{
    public $endpoint = 'api/v1/activation';

    /** @test */
    public function is_activating_user_account()
    {
        $userInative = factory(User::class)->create();
        $this->assertEquals(Status::INACTIVE, $userInative->status);

        $response = $this->json('GET', $this->endpoint . "/{$userInative->activation_hash}");
        $response->assertStatus(200);

        $refreshUserActiveNow =  User::find($userInative->id);
        $this->assertEquals(Status::ACTIVE, $refreshUserActiveNow->status);
    }

    /** @test */
    public function is_first_login()
    {
        $user = factory(User::class)->create();
        $this->assertEquals(true, $user->isFirstLogin());
    }
}