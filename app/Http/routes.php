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

$app->post('/users/auth', 'UserController@auth');
$app->post('/users/register', 'UserController@register');
$app->post('/reviews/create', 'ReviewController@create');
$app->post('/reviews/{id}/update', 'ReviewController@update');
$app->get('/reviews/movies/{id}', 'ReviewController@getByMovie');
$app->get('/reviews', 'ReviewController@getByUser');
$app->post('/password/forget', 'PasswordController@postEmail');
$app->get('/password/reset/{token}', 'PasswordController@getResetForm');
$app->post('/password/reset', ['uses' => 'PasswordController@postReset', 'as' => 'password.reset']);