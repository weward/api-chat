<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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
Route::prefix('embed')->group(function() {
    Route::post('/app-settings', 'Embed\RenderController@embedAppSettings');
    Route::post('/login', 'Embed\QueueController@connect');
});
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
    Route::prefix('chat')->group(function() {
        Route::get('/init-inbox', 'Admin\Chat\CustomerController@initInbox');
        Route::get('/add-new-customer', 'Admin\Chat\CustomerController@add');
        Route::post('/send-message', 'Admin\Chat\MessageController@send');
    });
});


// Broadcast::routes(['middleware' => 'auth:api']); 
Broadcast::routes(['middleware' => 'auth:sanctum']); 
// Broadcast::routes();
// Route::get('test', 'Admin\ChatController@test');
// use App\Models\ChatApp;
// Route::get('test', function() {
//     // dd(\Cache::get('356a192b7913b04c54574d18c28d46e6395428ab'));
//     // dd(\Cache::get('test'));
//     // dd(ChatApp::where('hash', '356a192b7913b04c54574d18c28d46e6395428ab')->first());
//     // dd(\Cache::forget('356a192b7913b04c54574d18c28d46e6395428ab'));

//     // if (!Cache::has('356a192b7913b04c54574d18c28d46e6395428ab')) {
//         // $chatApp = ChatApp::where('hash', '356a192b7913b04c54574d18c28d46e6395428ab')->first()->id;
//         // Cache::forever('356a192b7913b04c54574d18c28d46e6395428ab', $chatApp);
//     // } else {
//         // $chatApp = Cache::get('356a192b7913b04c54574d18c28d46e6395428ab');
//     // }

//     // dd($chatApp); 
// });