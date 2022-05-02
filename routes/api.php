<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'Auth'], function () {

    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/validate-token', 'AuthController@validateToken');
});

Route::group(['prefix' => 'v1'], function () {

    /*
    |---------------------------------------------------------------------------
    | Rotas protegidas por token [JWT]
    |---------------------------------------------------------------------------
    | Rotas que exigem um token para liberar o acesso e invalidam o token
    | após o uso, exigindo que o sistema atualize o token e o devolva no
    | cabeçalho de resposta da API.
    |
     */

    Route::group(['middleware' => ['api.jwt']], function () {

        Route::resource('user',         'UserController')->except('store');
        Route::resource('company',      'CompanyController');
        Route::resource('category',     'CategoryController');
        Route::resource('professional', 'ProfessionalController');
        Route::resource('officehours',  'OfficeHoursController');
        Route::resource('client',       'ClientController');
        Route::resource('product',      'ProductController');
        Route::resource('schedule',     'ScheduleController');
        Route::resource('affiliation',  'AffiliationController')->only(['store', 'update']);

        Route::patch('officehours/remove-interval/{officehour}',  'OfficeHoursController@removeInterval');
    });


    Route::post('user',             'UserController@store');
    Route::get('activation/{code}', 'ActivationController@active');

    Route::get('version',    'VersionController@index');
});
