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
    return view('pages.dashboard');
});

Route::group(['prefix' => 'plagiat', 'namespace' => 'App\Http\Controllers\Pliagiat', 'as' => 'plagiat.'], function(){
    Route::resource('en_ligne', 'PlagiatEnLigneController');
});
