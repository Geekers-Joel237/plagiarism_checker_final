<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

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
    return view('pages.home');
});

Route::post('uploadFile',[MediaController::class, 'uploadFile'])->name('uploadFile');
Route::post('comparePlagiat',[MediaController::class, 'comparePlagiat'])->name('comparePlagiat');
Route::post('generationRapport',[MediaController::class, 'generationRapport'])->name('generationRapport');



Route::group(['prefix' => 'plagiat', 'namespace' => 'App\Http\Controllers\Pliagiat', 'as' => 'plagiat.'], function(){
    Route::resource('en_ligne', 'PlagiatEnLigneController');
    Route::resource('en_local', 'PlagiatEnLocalController');
    Route::post('uploadFile',['App\Http\Controllers\Pliagiat\PlagiatEnLocalController','uploadFile'])->name('uploadFile');
    Route::post('traitementLocal',['App\Http\Controllers\Pliagiat\PlagiatEnLocalController','traitementLocal'])->name('traitementLocal');
    Route::resource('dashboard', 'DashboardController');
    Route::resource('settings', 'SettingsController');
    
});

Route::group(['prefix' => 'user', 'namespace' => 'App\Http\Controllers\User', 'as' => 'user.'], function (){
    Route::resource('DocumentADocument', 'DocumentADocumentController');
});
