<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'uses' => 'BlogController@index',
    'as' => 'blog'
]);

Route::get('/blog/{post}', [
    'uses' => 'BlogController@show',
    'as' => 'blog.show'
]);

Route::post('/blog/{post}', [
    'uses' => 'BlogController@comment',
    'as' => 'blog.comment'
]);

Route::get('/category/{category}', [
    'uses' => 'BlogController@category',
    'as' => 'category'
]);

Route::get('/author/{author}', [
    'uses' => 'BlogController@author',
    'as' => 'author'
]);

Route::get('/tag/{tag}', [
    'uses' => 'BlogController@tag',
    'as' => 'tag'
]);

Auth::routes(['register' => false]);

Route::get('/backend/home', 'Backend\HomeController@index')->name('home');

Route::name('backend.')->group(function(){
    Route::resource('/backend/blog', 'Backend\BlogController');
    Route::put('/backend/blog/restore/{blog}', [
        'uses' => 'Backend\BlogController@restore',
        'as' => 'blog.restore'
    ]);
    Route::delete('/backend/blog/force-destroy/{blog}', [
        'uses' => 'Backend\BlogController@forceDestroy',
        'as' => 'blog.force-destroy'
    ]);
    Route::resource('/backend/category', 'Backend\CategoryController');
    Route::resource('/backend/user', 'Backend\UserController');
    Route::get('/backend/user/confirm/{user}', [
        'uses' => 'Backend\UserController@confirm',
        'as' => 'user.confirm'
    ]);
    Route::get('backend/account/edit', [
        'uses' => 'Backend\HomeController@edit',
        'as' => 'account.edit'
    ]);
    Route::put('backend/account/edit', [
        'uses' => 'Backend\HomeController@update',
        'as' => 'account.update'
    ]);
    Route::resource('/backend/tag', 'Backend\TagController');
});
