<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth',
    'middleware' => 'api'
],function(){
    Route::post('login','App\Http\Controllers\Api\AuthController@login');
    Route::post('signup','App\Http\Controllers\Api\AuthController@signup');
    Route::get('refresh','App\Http\Controllers\Api\AuthController@refreshToken');
    Route::get('logout','App\Http\Controllers\Api\AuthController@logout');
    Route::get('me','App\Http\Controllers\Api\AuthController@me');
});

Route::group([
    'prefix' => 'v1',
    'middleware' => 'api'
],function(){
    Route::apiResource('users','App\Http\Controllers\Api\UserController');

    Route::get('teachers','App\Http\Controllers\Api\UserController@getTeachers');
    Route::post('seedlingUser', 'App\Http\Controllers\Api\SeedlingUserController@createSeedlingUser');
    Route::put('changeStatus/{id}', 'App\Http\Controllers\Api\SeedlingUserController@setStatus');

    Route::apiResource('departments','App\Http\Controllers\Api\DepartmentController');

    Route::get('groups/latest','App\Http\Controllers\Api\GroupController@getLatest');
    Route::apiResource('groups','App\Http\Controllers\Api\GroupController');
    Route::apiResource('lines','App\Http\Controllers\Api\LineController');
    Route::apiResource('programs','App\Http\Controllers\Api\ProgramController');
    Route::apiResource('publications','App\Http\Controllers\Api\PublicationController');

    Route::get('seedlings/latest','App\Http\Controllers\Api\SeedlingController@getLatest');
    Route::apiResource('seedlings','App\Http\Controllers\Api\SeedlingController');

    Route::get('roles','App\Http\Controllers\Api\RoleController@index');
});