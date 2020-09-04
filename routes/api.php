<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Admin\RegisterController@register');
Route::get('/verify/{id}/{hash}', ['uses' => 'Admin\RegisterController@verify', 'as' => 'verify']);
Route::post('/forgot-password', 'Admin\ForgotPasswordController@handle');
Route::get('/reset-password/{id}/{hash}', ['uses' => 'Admin\ForgotPasswordController@resetLink', 'as' => 'reset-password']);
Route::post('/login', 'Admin\AuthController@login');
Route::get('/resend-verification-email/{id}', [ 
    'uses' => 'Admin\RegisterController@resendVerificationEmail', 
    'as' => 'resend-verification-email'
]);

/**
 * Embedded Application
 */
// This is the point where <iFrames> connect
Route::post('/embed/app-settings', 'Embed\EmbedController@embedAppSettings');
/**
 * Authenticated Routes
 */
Route::middleware('auth:sanctum')->prefix('admin')->group(function() {
    Route::get('/logout', 'Admin\AuthController@logout');
    // Billing
    Route::prefix('billing')->group(function() {
        Route::get('/get-stripe', 'Admin\BillingController@index');
        Route::post('/setup-payment-method', 'Admin\BillingController@setupPaymentMethod');
    });
});
