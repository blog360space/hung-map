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

    //    Route::get('/', function () {
    //        return view('welcome');
    //    })->middleware('guest');

    
    Route::get('/', 'FeIndexController@getIndex');
    Route::get('/about', 'FeIndexController@getAbout');
    Route::get('/contact', 'FeIndexController@getContact');
    Route::get('/post', 'FeIndexController@getPost');
    
    Route::get('/other/tags', 'OtherController@getTags');
    Route::get('/other/branches', 'OtherController@getBranches');
    Route::get('/other/vehicles', 'OtherController@getVehicles');    
    
    Route::get('/admin/tasks', 'AdminTaskController@index');
    Route::post('/admin/task', 'AdminTaskController@store');
    Route::delete('/admin/task/{task}', 'AdminTaskController@destroy');
    
    Route::get('/admin/posts/create', 'AdminPostController@getCreate');
    Route::post('/admin/posts/store', 'AdminPostController@postStore');    
    Route::get('/admin/posts/edit/{id}/{slug}', 'AdminPostController@getEdit');
    Route::post('/admin/posts/update/{id}/{slug}', 'AdminPostController@postUpdate');    
    Route::get('/admin/posts', 'AdminPostController@index');
    Route::delete('/admin/posts/destroy/{id}', 'AdminPostController@destroy');
    
    Route::get('/admin/categories/create', 'AdminCategoryController@getCreate');
    Route::post('/admin/categories/store', 'AdminCategoryController@postStore');
    Route::get('/admin/categories/edit/{id}', 'AdminCategoryController@getEdit');
    Route::post('/admin/categories/update/{id}', 'AdminCategoryController@postUpdate');
    Route::get('/admin/categories/{type}', 'AdminCategoryController@index');
    Route::delete('/admin/categories/destroy/{id}', 'AdminCategoryController@deleteDestroy');
    
    Route::get('/admin/pages/create', 'AdminPageController@getCreate');
    Route::post('/admin/pages/store', 'AdminPageController@postStore');    
    Route::get('/admin/pages/edit/{id}/{slug}', 'AdminPageController@getEdit');
    Route::post('/admin/pages/update/{id}/{slug}', 'AdminPageController@postUpdate');    
    Route::get('/admin/pages', 'AdminPageController@index');
    Route::delete('/admin/pages/destroy/{id}', 'AdminPageController@destroy');
    
    Route::get('/admin/products/create', 'AdminProductController@getCreate');
    Route::post('/admin/products/store', 'AdminProductController@postStore');    
    Route::get('/admin/products/edit/{id}/{slug}', 'AdminProductController@getEdit');
    Route::post('/admin/products/update/{id}', 'AdminProductController@postUpdate');    
    Route::get('/admin/products', 'AdminProductController@index');
    Route::delete('/admin/products/destroy/{id}', 'AdminProductController@destroy');
    
    Route::get('/admin/upload/{type}/{id}', 'AdminUploadController@getIndex');
    Route::post('/admin/upload/{type}/{id}', 'AdminUploadController@postStore');
    Route::delete('/admin/upload/{type}/{id}', 'AdminUploadController@deleteDestroy');
    
    Route::get('/admin/profiles/change-password', 'AdminProfileController@getChangePassword');
    Route::post('/admin/profiles/change-password', 'AdminProfileController@postChangePassword');
    
    Route::auth();
});
