<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/topicos', App\Http\Controllers\TopicoController::class)
->except(['show'])
->middleware('auth');

Route::get('delete-video/{id}',[
    'as' => 'delete-topico',
    'middleware' => 'auth',
    'uses'=> 'App\Http\Controllers\TopicoController@delete_topico'
    ]);
    