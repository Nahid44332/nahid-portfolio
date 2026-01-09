<?php

use App\Http\Controllers\backend\AboutUsControlller;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\HeroSectionController;
use App\Http\Controllers\backend\ProjectController;
use App\Http\Controllers\backend\ServiceController;
use App\Http\Controllers\backend\SkillExperienceController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [FrontendController::class, 'index']);
Route::get('/admin/login', [FrontendController::class, 'adminLogin']);
Route::get('/admin/logout', [FrontendController::class, 'adminLogout']);
Auth::routes();

Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard']);
Route::get('/admin/hero-section', [HeroSectionController::class, 'heroSection']);
Route::post('/admin/hero-section/update', [HeroSectionController::class, 'heroSectionUpdate']);

//About Us Route...
Route::get('/admin/about-us', [AboutUsControlller::class, 'abooutUs']);
Route::post('/admin/about/store', [AboutUsControlller::class, 'store']);

//Skill Route...
Route::get('/admin/skill-experience', [SkillExperienceController::class, 'index'])->name('skill_experience.index');
Route::post('/admin/skill-experience/store', [SkillExperienceController::class, 'store'])->name('skill_experience.store');
Route::delete('/backend/skill-experience/delete/{type}/{id}', [SkillExperienceController::class, 'delete'])->name('skill_experience.delete');

//Service Route...
Route::get('/admin/services', [ServiceController::class, 'manage'])->name('admin.services');
Route::post('/admin/services/store', [ServiceController::class, 'store'])->name('admin.services.store');
Route::delete('/admin/services/{id}', [ServiceController::class, 'destroy'])->name('admin.services.delete');

//Project Route....
Route::get('/admin/project', [ProjectController::class, 'Project']);
Route::post('/admin/project/store', [ProjectController::class, 'ProjectStore']); 