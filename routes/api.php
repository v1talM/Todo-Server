<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
Route::group(['middleware' => 'cors'], function(){
    Route::get('/todos', 'TodoController@index');
    Route::post('/todos', 'TodoController@store');
    Route::patch('/todo/{id}', 'TodoController@changeToDoing');
    Route::patch('/todone/{id}', 'TodoController@changeToDone');
    Route::delete('/todo/{id}', 'TodoController@destroy');
});
