<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\CarMasterController;
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

    Route::middleware('roles:1,5')->group(function () {
        Route::get('/transfer-stock', [StockController::class, 'show'])->name('transfer-stock');
        Route::get('/gate-pass/{id}', [StockController::class, 'getGatePass'])->name('gate-pass');
    });
    
    Route::middleware('roles:1,6')->group(function () {
        Route::get('/receive-stock/{id}', [StockController::class, 'getReceiveStock'])->name('receive-stock');
        Route::post('/submit-receive-stock/{id}', [StockController::class, 'submitReceiveStock'])->name('submit-receive-stock');
    });
    Route::middleware('roles:1')->group(function () {
        Route::delete('/delete-transfer-stock/{id}', [StockController::class, 'destroy'])->name('delete-transfer-stock');
    });

    Route::get('/stock-details/{id}', [StockController::class, 'getStockDetails'])->name('stock-details');
    Route::post('/submit-transfer-stock', [StockController::class, 'store'])->name('submit-transfer-stock');
    Route::get('/car-details', [StockController::class, 'getCarDetais'])->name('car-details');

    Route::get('/generate-gat-pass-pdf/{id}', [StockController::class, 'generateGatePassPDF'])->name('print-gate-pass-pdf');

    Route::get('/upload-car-stock', [CarMasterController::class, 'index'])->name('upload-car-stock');
    Route::post('/upload-car-sheets', [CarMasterController::class, 'store'])->name('upload-car-sheets');
});
