<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(FrontendController::class)->group(function () {
    Route::get('/home', 'home');
});
