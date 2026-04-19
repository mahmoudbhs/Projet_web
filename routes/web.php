<?php

use Illuminate\Support\Facades\Route;
use App\Models\Review;
use App\Http\Controllers\AdminController;

Route::view('/', 'welcome');
Route::view('/login', 'login');
Route::view('/register', 'register');
Route::view('/reviews', 'reviews');

Route::get('/admin', [AdminController::class, 'index']);