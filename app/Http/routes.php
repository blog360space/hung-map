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
    Route::get('/post/{slug?}.{id?}', 'FeIndexController@getPost');
    Route::get('/post/category/{slug?}.{id?}', 'FeIndexController@getCategory');
    Route::get('/post/tag/{slug?}', 'FeIndexController@getTag');
    
    Route::get('/other/tags', 'OtherController@getTags');
    Route::get('/other/branches', 'OtherController@getBranches');
    Route::get('/other/vehicles', 'OtherController@getVehicles');        
    
    Route::get('/admin/tasks', 'Admin\TaskController@index');
    Route::post('/admin/task', 'Admin\TaskController@store');
    Route::delete('/admin/task/{task}', 'Admin\TaskController@destroy');
    
    Route::get('/admin/posts/create', 'Admin\PostController@getCreate');
    Route::post('/admin/posts/store', 'Admin\PostController@postStore');    
    Route::get('/admin/posts/edit/{id}/{slug}', 'Admin\PostController@getEdit');
    Route::post('/admin/posts/update/{id}/{slug}', 'Admin\PostController@postUpdate');    
    Route::get('/admin/posts', 'Admin\PostController@index');
    Route::delete('/admin/posts/destroy/{id}', 'Admin\PostController@destroy');
    
    Route::get('/admin/categories/create', 'Admin\CategoryController@getCreate');
    Route::post('/admin/categories/store', 'Admin\CategoryController@postStore');
    Route::get('/admin/categories/edit/{slug?}.{id?}', 'Admin\CategoryController@getEdit');
    Route::post('/admin/categories/update/{id}', 'Admin\CategoryController@postUpdate');
    Route::get('/admin/categories/{type}', 'Admin\CategoryController@index');
    Route::delete('/admin/categories/destroy/{id}', 'Admin\CategoryController@deleteDestroy');
    
    Route::get('/admin/pages/create', 'Admin\PageController@getCreate');
    Route::post('/admin/pages/store', 'Admin\PageController@postStore');    
    Route::get('/admin/pages/edit/{id}/{slug}', 'Admin\PageController@getEdit');
    Route::post('/admin/pages/update/{id}/{slug}', 'Admin\PageController@postUpdate');    
    Route::get('/admin/pages', 'Admin\PageController@index');
    Route::delete('/admin/pages/destroy/{id}', 'Admin\PageController@destroy');
    
    Route::get('/admin/products/create', 'Admin\ProductController@getCreate');
    Route::post('/admin/products/store', 'Admin\ProductController@postStore');    
    Route::get('/admin/products/edit/{id}/{slug}', 'Admin\ProductController@getEdit');
    Route::post('/admin/products/update/{id}', 'Admin\ProductController@postUpdate');    
    Route::get('/admin/products', 'Admin\ProductController@index');
    Route::delete('/admin/products/destroy/{id}', 'Admin\ProductController@destroy');
    
    Route::get('/admin/upload/{type}/{id}', 'Admin\UploadController@getIndex');
    Route::post('/admin/upload/{type}/{id}', 'Admin\UploadController@postStore');
    Route::delete('/admin/upload/{type}/{id}', 'Admin\UploadController@deleteDestroy');
    
    Route::get('/admin/profiles/change-password', 'Admin\ProfileController@getChangePassword');
    Route::post('/admin/profiles/change-password', 'Admin\ProfileController@postChangePassword');
    
    Route::auth();
});
