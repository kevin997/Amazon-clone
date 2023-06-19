<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// test
Route::get('/test', function(){
    return ('test');
});

// on affiche une page de notification au cas ou l'utilisateur n'a pas verifie son email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// on traite la verification de l'email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    //return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// En cas de non reception de l'email de verification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// protection de certaines routes exclusivement reservees aux utilisateurs dont l'email a ete verifie
Route::get('/profile', function () {
    // Only verified users may access this route...
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// inscription des utilisateurs
Route::post('/register', [UserController::class, 'register']);

// connexion
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
