<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

use GuzzleHttp\Client;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('competitions', 'CompetitionController');

Route::get('home', function () {
    return (new Response(['name' => 'Abigail', 'state' => 'CA'], 200))
                  ->header('Content-Type', 'application/json;charset=UTF-8');
});