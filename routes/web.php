<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/login', 'login');
Route::view('/register', 'register');
Route::view('/reviews', 'reviews');
Route::view('/admin', 'admin');