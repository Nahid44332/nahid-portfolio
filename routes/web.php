<?php

use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [FrontendController::class, 'index']);
Route::get('/admin/login', [FrontendController::class, 'adminLogin']);
Auth::routes();

Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard']);
