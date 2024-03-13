<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageController;

Route::get('/images', [ImageController::class, 'index'])->name('images.index');
Route::get('/images/upload', [ImageController::class, 'create'])->name('images.upload');
Route::post('/images', [ImageController::class, 'store'])->name('images.store');
