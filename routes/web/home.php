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


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

Route::get('/', function (\App\FooService $fooService) {
    if (Gate::allows('edit-user')){
        return view('welcome');
    }

    return 'NO';
//    dd($fooService->max(10, 3712), \App\Foo::doSomething('sms', 'Bahman'));
    return view('welcome');

//    $product = \App\Product::find(1);
//
//    auth()->user()->comments()->create([
//        'comment' => 'گوشی قشنگو پر کاربردی من راضیم ازش',
//        'commentable_id' => $product->id,
//        'commentable_type' => get_class($product)
//    ]);
//
//    return $product->comments()->get();
});

Auth::routes(['verify' => true]);
Route::get('/auth/google', 'Auth\GoogleAuthController@redirect')->name('auth.google');
Route::get('/auth/google/callback', 'Auth\GoogleAuthController@callback');
Route::get('/auth/token', 'Auth\AuthTokenController@getToken')->name('2fa.token');
Route::post('/auth/token', 'Auth\AuthTokenController@postToken');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::prefix('profile')->namespace('Profile')->middleware('auth')->group(function (){
    Route::get('/', 'IndexController@index')->name('profile');
    Route::get('twofactor', 'TwoFactorAuthController@manageTwoFactor')->name('two.factor');
    Route::post('twofactor', 'TwoFactorAuthController@postManageTwoFactor')->name('two.factor.manage');

    Route::get('twofactor/phone', 'TokenAuthController@getPhoneVerify')->name('profile.2fa.phone');
    Route::post('twofactor/phone', 'TokenAuthController@postPhoneVerify');
});

Route::get('products', 'ProductController@index');
Route::get('products/{product}', 'ProductController@single');
Route::post('comments', 'HomeController@comment')->name('send.comment');

Route::get('/secret', function (){
    return 'Secret';
})->middleware(['auth', 'password.confirm']);
