<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


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


Route::get('/privacy', function () {
    return view('privacy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/league/{id}', [App\Http\Controllers\HomeController::class, 'league'])->name('league');



Route::get('/league/{league_id}/user/{user_id}', [App\Http\Controllers\HomeController::class, 'user_stats'])->name('user_stats');
Route::post('/enter_league', [App\Http\Controllers\HomeController::class, 'enter_league'])->name('enter_league');
Route::post('/create_league', [App\Http\Controllers\HomeController::class, 'create_league'])->name('create_league');

Route::post('/add_match', [App\Http\Controllers\HomeController::class, 'add_match'])->name('add_match');
Route::post('/delete_match', [App\Http\Controllers\HomeController::class, 'delete_match'])->name('delete_match');

Route::get('login/facebook', [LoginController::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [LoginController::class, 'handleProviderCallback']);