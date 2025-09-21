<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::any('/user/login', 'userLogin');
});

Route::controller(BackendController::class)->group(function () {
    Route::middleware(['auth', 'verified','role:admin'])->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/userLogOut', 'userLogOut')->name('userLogOut');
    });
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
