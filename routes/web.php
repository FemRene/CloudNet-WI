<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['cloudnet.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');
})->name("dashboard.");

require __DIR__.'/auth.php';
