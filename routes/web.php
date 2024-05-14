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
    return view('index');
});

Route::get('/main', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/scrape', function () {
    return view('scrape');
});

Route::get('/nst', [App\Http\Controllers\NewsController::class, 'nst'])->name('nst');
Route::get('/star', [App\Http\Controllers\NewsController::class, 'star'])->name('star');
Route::post('/deletemultip', [App\Http\Controllers\NewsController::class, 'deletemultiprec'])->name('deletemultip');
Route::post('/deleterec', [App\Http\Controllers\NewsController::class, 'deleterec'])->name('deleterec');
Route::get('/newsdata', [App\Http\Controllers\NewsController::class, 'newsdata'])->name('newsdata');
Route::post('/scrapedata', [App\Http\Controllers\NewsController::class, 'scrapedata'])->name('scrapedata');
Route::get('/makepdf', [App\Http\Controllers\NewsController::class, 'makepdf'])->name('makepdf');





