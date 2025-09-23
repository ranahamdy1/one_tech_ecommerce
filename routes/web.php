<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::any('/user/login', 'userLogin')->name('user.login');
    Route::any('/newAccount', 'newAccount')->name('user.register');

    Route::any('/userForgetPassword', 'userForgetPassword')->name('userForgetPassword');
    Route::any('/userResetPassword', 'userResetPassword')->name('userResetPassword');
    Route::get('/userUpdatePassword/{id}', 'userUpdatePassword')->name('userUpdatePassword');
    Route::any('/userUpdatedPassword', 'userUpdatedPassword');

    Route::get('/error_403', 'error403')->name('error_403');
    Route::get('/error_404', 'error404')->name('error_404');
});

Route::controller(FrontendController::class)->group(function () {
    Route::middleware(['auth', 'verified','role:user'])->group(function () {
        Route::get('/userLogOut', 'userLogOut')->name('userLogOut');
    });
});

Route::controller(BackendController::class)->group(function () {
    Route::middleware(['auth', 'verified','role:admin'])->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/adminLogOut', 'adminLogOut')->name('adminLogOut');
        Route::get('/addCategory', 'addCategory')->name('addCategory');
        Route::post('/addCategoryStore', 'addCategoryStore')->name('addCategoryStore');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
