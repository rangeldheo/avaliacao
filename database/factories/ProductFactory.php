<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $user = User::where('id', '<>', '1')->get();
    $max  = $user->count() - 1;

    $comp = Company::get();
    $maxComp  = $comp->count() - 1;

    $cat = Category::get();
    $maxCat  = $cat->count() - 1;

    $products = [
        'Limpeza de pele',
        'Hidratação facial',
        'Esfoliação',
        'Drenagem linfática',
        'Maquiagem',
        'Design de sobrancelhas',
        'Massagem relaxante',
        'Massagem terapêutica',
    ];

    $maxProd = sizeof($products) - 1;

    $price = rand(30, 500);
    $comission = $price * (rand(2,95) * 0.23 / 100);

    return [
        'company_id' => $comp[rand(0, $maxComp)]->id,
        'category_id' => $cat[rand(0, $maxCat)]->id,
        'user_id' => $user[rand(0, $max)]->id,
        'title' => $products[rand(0, $maxProd)],
        'description' => $faker->sentence(6, true),
        'price' => $price,
        'commission' => $comission,
        'commission_type' => rand(0,1),
        'status' => 0
    ];
});
