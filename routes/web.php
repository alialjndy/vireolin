<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::controller(EmailVerificationController::class)->withoutMiddleware('verified')->group(function () {
//     Route::get('/email/verify/{id}/{hash}', 'verify')
//         ->middleware(['signed'])
//         ->name('verification.verify');
// });
