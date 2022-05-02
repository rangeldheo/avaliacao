<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Services\ActivationServices;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $now = Carbon::now()->addHour(1);
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '12345678', // password 12345678
        'remember_token' => Hash::make(Str::random(10)),
        'activation_hash' =>  ActivationServices::hashGenerate('rangeldheo@gmail.com'),
        'first_login' => 1,
        'activation_expires' => $now
    ];
});