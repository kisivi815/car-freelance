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
    /* Route::get('/dashboard', function () {
        return view('dashboard')->with(['title' => 'Dashboard']);;
    })->name('dashboard'); */

    Route::get('/quick-sale', function () {
        return view('quick-sale')->with(['title' => 'Quick Sale']);
    })->name('quick-sale');
    
    Route::get('/view-sale', function () {
        return view('view-sale')->with(['title' => 'View Sale']);
    })->name('view-sale');
    
    Route::get('/view-stock', [StockController::class, 'index'])->name('view-stock');

    Route::get('/stock-details', function () {
        return view('view-stock')->with(['title' => 'View Stock']);
    })->name('view-stock-default');

    Route::get('/transfer-stock', [StockController::class, 'show'])->name('transfer-stock');
    Route::get('/receive-stock/{id}', [StockController::class, 'getReceiveStock'])->name('receive-stock');
    Route::get('/stock-details/{id}', [StockController::class, 'getStockDetails'])->name('stock-details');
    Route::post('/submit-receive-stock/{id}', [StockController::class, 'submitReceiveStock'])->name('submit-receive-stock');
    Route::post('/submit-transfer-stock', [StockController::class, 'store'])->name('submit-transfer-stock');
    

});
