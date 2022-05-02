<?php

namespace Tests\Unit\User;

use App\Http\Requests\User\UserStoreRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStoreRequestTest extends TestCase
{
    public $endpoint = 'api/v1/user';

    /** @test */
    public function the_rule_required_is_being_respected()
    {
        $userForValidate = [];
        $unprocessableEntity = 422;

        $response = $this->json('POST', $this->endpoint, $userForValidate);
        $response->assertStatus($unprocessableEntity)
            ->assertJsonStructure([
                'data' => [],
                'error' => [
                    'list' => [
                        "name" => [],
                        "email" => [],
                        "password" => [],
                        "password_confirmation" => []
                    ],
                    'sent_api' => []
                ]
            ]);
    }

    /** @test */
    public function the_rule_min_is_being_respected()
    {
        $userMinStringsForValidate = [
            "name" => "Jo",
            "email" => "emailtest@gmail.com",
            "password" => "12",
            "password_confirmation" => "12"
        ];
        $unprocessableEntity = 422;

        $response = $this->json('POST', $this->endpoint, $userMinStringsForValidate);
        $response->assertStatus($unprocessableEntity)
            ->assertJsonStructure([
                'data' => [],
                'error' => [
                    'list' => [
                        "name" => [],
                        "password" => [],
                        "password_confirmation" => [],
                    ],
                    'sent_api' => []
                ]
            ]);
    }

    /** @test */
    public function the_rule_email_is_being_respected()
    {
        $userMinStringsForValidate = [
            "name" => "João da Silva",
            "email" => "x@x.x",
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ];
        $unprocessableEntity = 422;

        $response = $this->json('POST', $this->endpoint, $userMinStringsForValidate);
        $response->assertStatus($unprocessableEntity)
            ->assertJsonStructure([
                'data' => [],
                'error' => [
                    'list' => [
                        "email" => [],
                    ],
                    'sent_api' => []
                ]
            ]);
    }

    /** @test */
    public function the_rule_password_confirmation_is_being_respected()
    {
        $userPasswordConfirmationIncorrect = [
            "name" => "João da Silva",
            "email" => "emailtest@gmail.com",
            "password" => "12345678",
            "password_confirmation" => "1234"
        ];
        $unprocessableEntity = 422;

        $response = $this->json('POST', $this->endpoint, $userPasswordConfirmationIncorrect);
        $response->assertStatus($unprocessableEntity)
            ->assertJsonStructure([
                'data' => [],
                'error' => [
                    'list' => [
                        "password" => [],
                    ],
                    'sent_api' => []
                ]
            ]);
    }
}