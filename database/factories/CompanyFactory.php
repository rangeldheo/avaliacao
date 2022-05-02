<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use App\User;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    $user = User::where('id', '<>', '1')->get();
    $max  = $user->count() - 1;
    return [
        'user_id'        => $user[rand(0, $max)]->id,
        'corporate_name' => $faker->company,
        'status'         => rand(0, 2),
        'corporate_doc' => rand(11111111111111, 9999999999999),
        'manager' => $faker->name(),
        'mobile_phone' =>  rand(55111111111111, 5599999999999),
        //'web_site'
        'zipcode' => $faker->postcode,
        'street' => $faker->streetName,
        //'complement',
        'number' => $faker->buildingNumber,
        'district' => $faker->cityPrefix,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => 'Brasil'
    ];
});
