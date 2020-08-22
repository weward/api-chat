<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\User;
use App\Models\Company;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get Stripe
     * 
     * @test
     */
    public function initBillingIndexPage()
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

        $this->getJson('/api/admin/billing/get-stripe')->assertStatus(200);
    }

    /**
     * Setup Payment Method
     * 
     * @test
     */
    public function setupPaymentMethod()
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
        
        // Create a stripe customer
        $this->getJson('/api/admin/billing/get-stripe');

        // Setup payment method
        $res = $this->postJson('/api/admin/billing/setup-payment-method', [
            'payment_method' => 'pm_card_visa'
        ]);
        
        $res->assertStatus(200);
    }

}
