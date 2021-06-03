<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('login/google',[\App\Http\Controllers\Auth\LoginController::class,'redirectGoogle'])->name('google.login');
Route::get('login/google/callback',[\App\Http\Controllers\Auth\LoginController::class,'handleGoogleCallback']);

Route::get('login/github',[\App\Http\Controllers\Auth\LoginController::class,'redirectGithub'])->name('github.login');
Route::get('login/github/callback',[\App\Http\Controllers\Auth\LoginController::class,'handleGithubCallback']);

Route::get('login/facebook',[\App\Http\Controllers\Auth\LoginController::class,'redirectFacebook'])->name('facebook.login');
Route::get('login/facebook/callback',[\App\Http\Controllers\Auth\LoginController::class,'handleFacebookCallback']);
//Route::get('/customer',[\App\Http\Controllers\CustomerController::class,'index']);





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// testing

Route::post('/user/register',[\App\Http\Controllers\UserController::class,'registerUser'])->name('user.register');
Route::get('/user/verify/{token}',[\App\Http\Controllers\UserController::class,'verifyMail'])->name('user.verify');

Route::post('user/login',[\App\Http\Controllers\UserController::class,'validateLogin'])->name('user.login');


