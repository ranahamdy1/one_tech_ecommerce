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

    Route::get('/productByCategory/{id}', 'productByCategory')->name('productByCategory');
    Route::get('/productDetailsView/{id}', 'productDetailsView')->name('productDetailsView');

    Route::get('/superDeals', 'superDeals')->name('superDeals');
    Route::get('/allProducts', 'allProducts')->name('allProducts');

    Route::any('/searchProducts', 'searchProducts')->name('searchProducts');
    Route::get('/searchResult/{product}', 'searchResult')->name('searchResult');

    Route::any('/addCart', 'addCart')->name('addCart');
    Route::get('/viewCart', 'viewCart')->name('viewCart');
    Route::post('/deleteProductFromCart/{id}', 'deleteProductFromCart')->name('deleteProductFromCart');
    Route::post('/emptyCart', 'emptyCart')->name('emptyCart');

    Route::get('/addWishList/{id}', 'addWishList')->name('addWishList');
    Route::get('/wishList', 'wishList')->name('wishList');
    Route::post('/deleteProductFromFav/{id}', 'deleteProductFromFav')->name('deleteProductFromFav');
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

        //categories
        //add
        Route::get('/addCategory', 'addCategory')->name('addCategory');
        Route::post('/addCategoryStore', 'addCategoryStore');

        //show
        Route::get('/category', 'category')->name('category');

        //edit
        Route::get('/editCategory/{id}', 'editCategory')->name('editCategory');
        Route::any('/updateCategory', 'updateCategory');

        Route::any('/deleteCategory', 'deleteCategory');

        //products
        //add
        Route::get('/addProducts', 'addProducts')->name('addProducts');
        Route::any('/addProductsStore', 'addProductsStore');

        //show
        Route::get('/product', 'product')->name('product');

        //edit
        Route::get('/editProduct/{id}', 'editProduct')->name('editProduct');
        Route::any('/updateProduct', 'updateProduct');

        //delete
        Route::any('/deleteProduct', 'deleteProduct');

        //FeaturedProduct
        //add
        Route::get('/addFeaturedProduct', 'addFeaturedProduct')->name('addFeaturedProduct');
        Route::post('/addFeaturedProductStore', 'addFeaturedProductStore');

        //show
        Route::get('/viewFeaturedProduct', 'viewFeaturedProduct')->name('viewFeaturedProduct');

        //edit
        Route::get('/editFeaturedProduct/{id}', 'editFeaturedProduct')->name('editFeaturedProduct');
        Route::any('/updateFeaturedProduct', 'updateFeaturedProduct');

        //delete
        Route::any('/deleteFeaturedProduct', 'deleteFeaturedProduct');

    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
