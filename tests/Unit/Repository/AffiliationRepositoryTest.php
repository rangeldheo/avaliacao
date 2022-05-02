<?php

namespace Tests\Unit\Repository;

use App\Enums\AffiliationStatus;
use App\Models\Affiliation;
use DatabaseSeeder;
use App\Models\Company;
use App\Models\Professional;
use App\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AffiliationRepositoryTest extends TestCase
{
    public $user;
    public $professional;
    public $endpoint = 'api/v1/affiliation';
    public $tokenJwt;

    public function boot()
    {
        $db = new DatabaseSeeder();
        $db->run();

        $this->professional  = Professional::first();
        $this->user = User::where('id', $this->professional->user_id)->first();
        $token = JWTAuth::fromUser($this->user);
        $this->tokenJwt = ['Authorization' => "Bearer {$token}"];
    }

    /** @test */
    public function is_storing_e2e()
    {
        $this->withoutExceptionHandling();
        $this->boot();

        $company = Company::first();
        $dataForStore = [
            'company_id' => $company->id
        ];

        $response = $this->json(
            'POST',
            $this->endpoint,
            $dataForStore,
            $this->tokenJwt
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'professional_id',
                    'company_id',
                    'status',
                    'start_affiliation',
                    'justification',
                ],
                'error',
                'message'
            ]);

        $affiliationCreated = (object) $response->json();

        $this->assertEquals(
            AffiliationStatus::STAND_BY,
            $affiliationCreated->data['status']
        );
    }

    /** @test */
    public function id_updating_e2e()
    {
        $this->withoutExceptionHandling();
        $this->boot();

        $company      = Company::first();
        $dataForStore = [
            'company_id' => $company->id
        ];

        $response = $this->json(
            'POST',
            $this->endpoint,
            $dataForStore,
            $this->tokenJwt
        );

        $affiliationCreated = (object) $response->json();
        $dataForUpdate = ['approval_affiliation' => true];

        $response = $this->json(
            'PUT',
            $this->endpoint . "/{$affiliationCreated->data['id']}",
            $dataForUpdate,
            $this->tokenJwt
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'professional_id',
                    'company_id',
                    'status',
                    'start_affiliation',
                    'justification',
                ],
                'error',
                'message'
            ]);

        $affiliationAproveStatus = $response->json();
        $this->assertEquals(1, $affiliationAproveStatus['data']['status']);
    }
}
