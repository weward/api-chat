<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendForgotPasswordEmail;
use Tests\TestCase;
use App\User;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Send User An Email Upon Request
     * 
     * @test
     */
    public function sentUserAResetPasswordEmail()
    {
        Bus::fake();

        $user = factory(User::class)->create();

        $this->postJson('/api/forgot-password', [
            'email' => $user->email
        ]);

        Bus::assertDispatched(SendForgotPasswordEmail::class);
    }

    /**
     * Verify Reset Password Link From Email
     * 
     * @test
     */
    public function verifiedResetPasswordLinkFromEmail()
    {
        $user = factory(User::class)->create();
        $hash = sha1(rand(100, 999));

        \DB::table('reset_passwords')->insert([
            'user_id' => $user->id,
            'hash' => $hash,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString()
        ]);

        $this->getJson("/api/reset-password/{$user->id}/{$hash}")
            ->assertRedirect(env('FRONTEND_APP_URL') . "/change-password/{$user->id}/{$hash}");
    }

}
