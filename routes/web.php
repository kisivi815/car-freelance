<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('/quick-sale', function () {
    return view('quick-sale')->with(['title' => 'Quick Sale']);
})->name('quick-sale');

Route::get('/transfer-stock', function () {
    return view('transfer-stock')->with(['title' => 'Transfer Stock']);
})->name('transfer-stock');


Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware(RedirectIfAuthenticated::class)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard')->with(['title' => 'Dashboard']);;
    })->name('dashboard');
});