<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
// use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
Route::get('/stock/{stock}/edit', [StockController::class, 'edit'])->name('stock.edit');
Route::put('/stock/{stock}/update', [StockController::class, 'update'])->name('stock.update');
Route::delete('/stock/{stock}/destroy', [StockController::class, 'destroy'])->name('stock.destroy');

   Route::get('/dashboard', [StockController::class, 'dashboard'])->name('dashboard');
 Route::resource('stocks', StockController::class);
//  Route::get('/stocks/dashboard', [StockController::class, 'dashboard'])->name('stocks.dashboard');

//   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
// Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
// Route::get('/dashboard/live-data', [DashboardController::class, 'fetchLiveData'])->name('dashboard.liveData');
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('/dashboard', [StockController::class, 'index'])->name('stocks.index');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
