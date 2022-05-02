<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use App\User;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    $user = User::where('id', '<>', '1')->get();
    $max  = $user->count() - 1;

    return [
        'user_id'      => $user[rand(0, $max)]->id,
        'document'     => rand(11111111111111, 9999999999999),
        'nickname'     => $faker->name(),
        'mobile_phone' =>  rand(55111111111111, 5599999999999),
        //'web_site'
        'zipcode'      => $faker->postcode,
        'street'       => $faker->streetName,
        //'complement',
        'number'       => $faker->buildingNumber,
        'district'     => $faker->cityPrefix,
        'city'         => $faker->city,
        'state'        => $faker->state,
        'country'      => 'Brasil',
        'status'       => rand(0, 2)
    ];
});
