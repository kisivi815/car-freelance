<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\CarMasterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
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
    Route::get('/quick-booking',[SalesController::class,'show'])->name('quick-booking');
    Route::post('/submit-quick-sales', [SalesController::class, 'store'])->name('submit-quick-sales');
    Route::get('/quick-sales-gate-pass/{id}', [SalesController::class, 'getQuickSalesGatePass'])->name('quick-sales-gate-pass');
    Route::get('/generate-quick-sales-gate-pass-pdf/{id}', [SalesController::class, 'generateQuickSalesGatePassPDF'])->name('print-quick-sales-gate-pass-pdf');
    

    Route::get('/sales-form/{id?}',[SalesController::class,'salesForm'])->name('salesForm');
    Route::post('/submit-sales/{id?}', [SalesController::class, 'submitSalesForm'])->name('submit-sales');
    Route::delete('/delete-sales/{id?}', [SalesController::class, 'deleteSalesForm'])->name('delete-sales');
    Route::get('/send-of-approval-form/{id?}',[SalesController::class,'sendOfApproval'])->name('sendOfApproval');
    Route::post('/submit-send-of-approval-form/{id?}',[SalesController::class,'submitSendOfApproval'])->name('submitSendOfApproval');
    Route::get('/status-form/{id?}',[SalesController::class,'statusForm'])->name('statusForm');
    Route::post('/submit-status-form/{id?}',[SalesController::class,'submitSatusForm'])->name('submitSatusForm');
    Route::get('/salesCertificate',[SalesController::class,'salesCertificate'])->name('salesCertificate');
    Route::get('/tax-invoice',[SalesController::class,'taxInvoice'])->name('taxInvoice');

    
    
    
    Route::get('/view-sales',[SalesController::class,'index'])->name('view-sales');

    Route::get('/view-stock', [StockController::class, 'index'])->name('view-stock');

    Route::get('/view-inventory', [StockController::class, 'inventoryStock'])->name('inventory-stock');

    

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
    Route::post('/upload-car-details-sheets', [CarMasterController::class, 'storeCarDetails'])->name('upload-car-details-sheets');


    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/export-csv', [ReportController::class, 'exportCsv'])->name('exportCsv');
    
});
