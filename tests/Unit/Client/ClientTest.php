<?php

namespace Tests\Unit\Client;

use App\Models\Client;
use App\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientTest extends TestCase
{
    public $user;
    public $client;
    public $tokenJwt;
    public $endpoint = 'api/v1/client';

    public function boot()
    {
        $this->user  = factory(User::class)->create();
        $this->client = factory(Client::class)->create();
        $token = JWTAuth::fromUser($this->user);
        $this->tokenJwt = ['Authorization' => "Bearer {$token}"];
    }

    /** @test */
    public function client_index()
    {
        $this->withoutExceptionHandling();
        $this->boot();

        factory(Client::class, 2)->create();

        $response = $this->json('GET', $this->endpoint, [], $this->tokenJwt);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        $this->getJsonStructure(),
                        $this->getJsonStructure()
                    ]
                ]
            ]);
    }

    /** @test */
    public function client_store()
    {
        $this->withoutExceptionHandling();
        $this->boot();

        $client = $this->getInsertData();

        $response = $this->json('POST', $this->endpoint, $client, $this->tokenJwt);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->getJsonStructure()
            ]);
    }

    /** @test */
    public function client_not_store()
    {
        $this->boot();
        $client = [];
        $response = $this->json('POST', $this->endpoint, $client, $this->tokenJwt);
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
    public function client_update()
    {
        $this->withoutExceptionHandling();
        $this->boot();

        $dataForUpdate = $this->getInsertData();

        $response = $this->json(
            'PUT',
            "{$this->endpoint}/{$this->client->id}",
            $dataForUpdate,
            $this->tokenJwt
        );
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->getJsonStructure()
            ]);
    }

    /** @test */
    public function client_delete()
    {
        $this->boot();

        $response = $this->json(
            'DELETE',
            "{$this->endpoint}/{$this->client->id}",
            [],
            $this->tokenJwt
        );

        $response->assertStatus(200);
    }

    /**
     * Retorno: A estrutura do modelo num formato JSON
     * Motivação: Evita a repetição de codigo
     * @return array
     */
    public function getJsonStructure()
    {
        return [
            "id",
            "user_id",
            "mobile_phone",
            "document",
            "nickname",
            "zipcode",
            "street",
            "complement",
            "number",
            "district",
            "city",
            "state",
            "country",
            "status",
            "created_at",
            "updated_at",
            "document_format",
            "mobile_phone_format",
            "status_format"
        ];
    }

    public function getInsertData()
    {
        return [
            "mobile_phone" => "(37)99988-7766",
            "document" => "06950578636",
            "nickname" => "Dr. Maurine Kunde Jr.",
            "zipcode" => "10098",
            "street" => "Eichmann Ville",
            "complement" => null,
            "number" => "4015",
            "district" => "South",
            "city" => "Lake Phyllismouth",
            "state" => "Montana",
            "country" => "Brasil",
            "status" => 2
        ];
    }
}