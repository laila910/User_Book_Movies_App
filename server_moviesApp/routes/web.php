<?php

use Illuminate\Support\Facades\Route;


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



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')->name('users.')->group(base_path('routes/web/users.php'));

Route::prefix('movies')->name('movies.')->group(base_path('routes/web/movies.php'));
// Auth::routes(['register'=>false]);
// Auth::routes(['login'=>false]);

// Route::get('/logout', [Auth\LoginController::class,'logout'])->name('logout');

Auth::routes();

