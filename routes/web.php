<?php

use App\Http\Controllers\CMS\CMSContractController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ChangePasswordController;

Route::get('/', function () {
    return view('trangchu');
})->name('trangchu');

#auth
Route::get('/login', function(){
    return view('auth/login');
});
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/registerform',function(){
    return view('auth/register');
});
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/contract',[ContractController::class,'get']);

Route::get('/infor',[AccountController::class,'first'])->name('infor');

Route::get('/account',[AccountController::class,'index'])->name('account');
Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change.password.form');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change.password');

#CMSContract
Route::get('/CMSContract',[CMSContractController::class,'index']);

#products
Route::get('/products',[ProductController::class,'getproducts']);

#payment
Route::get('/payment',[ContractController::class,'getpayment'])->name('getpayment');
Route::post('/checkout/{contractID}',[StripeController::class,'checkout'])->name('checkout');
Route::get('/success/{contractID}',[StripeController::class,'success'])->name('success');