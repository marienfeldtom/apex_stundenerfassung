<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    //Products
    $router->get('products', ['uses' => 'ProductController@showAll']);
    $router->get('products/{id}', ['uses' => 'ProductController@showOne']);

    // Companies
    $router->get('companies', ['uses' => 'CompanyController@showAll']);
    $router->get('companies/{id}', ['uses' => 'CompanyController@showOne']);

    //Contact Form
    $router->post('contact', ['uses' => 'ContactController@create']);

    //Login
    $router->post('/login', 'LoginController@login');
    $router->post('/login/refresh', 'LoginController@refresh');
});


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    //Time Entries
    $router->get('time-entries', ['uses' => 'TimeEntryController@index']);
    $router->get('time-entries/{id}', ['uses' => 'TimeEntryController@show']);
    $router->post('time-entries', ['uses' => 'TimeEntryController@store']);
    $router->patch('time-entries', ['uses' => 'TimeEntryController@update']);
    $router->delete('time-entries', ['uses' => 'TimeEntryController@destroy']);

    $router->get('user/time-entries', ['uses' => 'TimeEntryController@indexOwned']);
});