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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/cars', function () {
        return view('carsIndex');
    });

    Route::get('/cars/add', function () {
        return view('carAdd');
    });

    Route::get('/cars/{id}', function ($id) {
        return view('carDetails')->with('id', $id);
    });
}); 

