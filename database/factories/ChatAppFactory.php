<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\ChatApp;
use Faker\Generator as Faker;

$factory->define(ChatApp::class, function (Faker $faker) {
    return [
        'hash' => sha1(1),
        'company_id' => 1,
        'name' => 'default',
        'domain' => 'http://chat.app/'
    ];
});
