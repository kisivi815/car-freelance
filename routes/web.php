<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);



Route::get('/', function () {
    return redirect('/login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');



Route::middleware(RedirectIfAuthenticated::class)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard')->with(['title' => 'Dashboard']);;
    })->name('dashboard');

    Route::get('/quick-sale', function () {
        return view('quick-sale')->with(['title' => 'Quick Sale']);
    })->name('quick-sale');
    
    Route::get('/view-sale', function () {
        return view('view-sale')->with(['title' => 'View Sale']);
    })->name('view-sale');
    
    Route::get('/view-stock', function () {
        return view('view-stock')->with(['title' => 'View Stock']);
    })->name('view-stock');

    Route::get('/transfer-stock', [StockController::class, 'index'])->name('transfer-stock');

});