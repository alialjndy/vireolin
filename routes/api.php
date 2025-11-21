<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\ServiceTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\Email;

Route::controller(AuthController::class)->group(function(){
    Route::post('register' , 'register');
    Route::post('login' ,'login');
    Route::middleware('auth:api')->post('logout' ,'logout');
});

Route::resource('serviceTypes' , ServiceTypeController::class)->middleware('auth:api');



Route::controller(EmailVerificationController::class)->group(function(){
    Route::get('email/verify/{id}/{hash}' , 'verify')->name('verification.verify');
    Route::post('email/verification-notification' , 'resend')->name('verification.resend');
});
