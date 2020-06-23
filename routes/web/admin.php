<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view('admin.index');
})->name('dashboard');
Route::namespace('Admin')->group(function (){
    Route::resource('users', 'User\UserController');
    Route::get('users/{user}/permissions', 'User\PermissionController@create')->name('users.permissions')->middleware('can:staff-user-permissions');
    Route::post('users/{user}/permissions', 'User\PermissionController@store')->name('users.permissions.store')->middleware('can:staff-user-permissions');
    Route::resource('permissions', 'PermissionController');
    Route::resource('roles', 'RoleController');
    Route::resource('products', 'ProductController')->except('show');
    Route::resource('comments', 'CommentController')->only(array('index', 'update', 'destroy'));
    Route::get('comments/unapproved', 'CommentController@unapproved')->name('comments.unapproved');
    Route::resource('categories', 'CategoryController')->except('show');
});