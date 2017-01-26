<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');
    
    Route::get('/other/tags', 'OtherController@tags');
    
    Route::get('/blade', function () {
        return view('frontend.child', [
            'name' => 'Hung gau'
        ]);
    })
    ->middleware('guest');
    
    Route::get('/json', function () {
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);

    })
    ->middleware('guest');

    Route::get('/tasks', 'TaskController@index');
    Route::post('/task', 'TaskController@store');
    Route::delete('/task/{task}', 'TaskController@destroy');
    
    Route::get('/posts/create', 'PostController@getCreate');
    Route::post('/posts/store', 'PostController@postStore');    
    Route::get('/posts/edit/{id}/{slug}', 'PostController@getEdit');
    Route::post('/posts/update/{id}/{slug}', 'PostController@postUpdate');    
    Route::get('/posts', 'PostController@index');
    Route::delete('/posts/destroy/{id}', 'PostController@destroy');
    
    Route::get('/categories/create', 'CategoryController@getCreate');
    Route::post('/categories/store', 'CategoryController@postStore');
    Route::get('/categories/edit/{id}', 'CategoryController@getEdit');
    Route::post('/categories/update/{id}', 'CategoryController@postUpdate');
    Route::get('/categories', 'CategoryController@index');
    Route::delete('/categories/destroy/{id}', 'CategoryController@deleteDestroy');
    
    Route::auth();
});