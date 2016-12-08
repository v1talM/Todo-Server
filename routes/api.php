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

Route::group(['middleware' => 'auth:api'], function (){
    Route::get('undo', 'TodoController@getUndoByUser');
    Route::get('doing', 'TodoController@getDoingByUser');
    Route::get('did', 'TodoController@getDidByUser');
    Route::get('/changeToUndo/{id}', 'TodoController@changeToUndo');
    Route::get('/changeToDoing/{id}', 'TodoController@changeToDoing');
    Route::get('/changeToDid/{id}', 'TodoController@changeToDid');
    Route::post('todo', 'TodoController@addTodoByUser');
    Route::get('todo/{id}', 'TodoController@delTodoByUser');
});

Route::post('register', 'Auth\RegisterController@create');

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function (){
   Route::get('users', 'UserController@getUserList');
});

Route::get('/test',function(){

    return response([1,2,3,4],200);
});
