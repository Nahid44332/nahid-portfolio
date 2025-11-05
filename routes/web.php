<?php

use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\HeroSectionController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [FrontendController::class, 'index']);
Route::get('/admin/login', [FrontendController::class, 'adminLogin']);
Route::get('/admin/logout', [FrontendController::class, 'adminLogout']);
Auth::routes();

Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard']);
Route::get('/admin/hero-section', [HeroSectionController::class, 'heroSection']);
Route::post('/admin/hero-section/store', [HeroSectionController::class, 'heroSectionStore']);