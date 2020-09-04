<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Hash;
use Laravel\Sanctum\Sanctum;
use App\User;
use App\Models\Company;
use App\Jobs\SendVerificationEmail;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Login
     * 
     * @test
     */
    public function loggedInSuccessfully()
    {
        factory(Company::class)->create();
        $user = factory(User::class)->create([
            'password' => Hash::make('secret123')
        ]);
        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secret123'
        ])->assertStatus(200);

    }

    /**
     * Login Failed Validation
     * 
     * @test
     */
    public function loginFailedValidation()
    {
        factory(Company::class)->create();
        $user = factory(User::class)->create([
            'password' => Hash::make('secret123')
        ]);
        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => ''
        ])->assertStatus(422);
    }

    /**
     * Login Failed
     * 
     * @test
     */
    public function loginFailed()
    {
        factory(Company::class)->create();
        $user = factory(User::class)->create([
            'password' => Hash::make('secret123')
        ]);
        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'asdasdsadf'
        ])->assertStatus(500);
    }    

    /**
     * Sent Email Verification
     * 
     * @test
     */
    public function sentEmailVerification()
    {
        Bus::fake();

        factory(Company::class)->create();
        $user = factory(User::class)->create([
            'password' => Hash::make('secret123')
        ]);

        $this->getJson("/api/resend-verification-email/{$user->id}");

        // Assert a job was pushed to a given queue...
        Bus::assertDispatched(SendVerificationEmail::class);
    }

    /**
     * @test
     */
    public function loggedOutSuccessfully()
    {
        $company = factory(Company::class)->create();

        Sanctum::actingAs(
            $user = factory(User::class)->create([
                'company_id' => $company->id
            ]),
            []
        );

        $company->in_charge = $user->id;
        $company->save();

        $res = $this->getJson('api/admin/logout')
            ->assertStatus(200);
    }
}
