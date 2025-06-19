<?php

use App\Livewire\Order\HistoryPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/order', function () {
    return view('order'); // Ini memberitahu Laravel untuk menampilkan file 'order.blade.php'
})->middleware(['auth'])->name('order'); // 'auth' berarti hanya user yang login bisa akses

Route::get('/orders/{order}/receipt', [ReceiptController::class, 'print'])
    ->middleware('auth')
    ->name('receipt.print');

Route::get('/my-orders', HistoryPage::class)
    ->middleware('auth')
    ->name('order.history');


require __DIR__.'/auth.php';
