<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\InterviewFeedbackController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\TerminationController;
use App\Http\Controllers\Auth\LoginController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Employee Routes
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/grid', [EmployeeController::class, 'grid'])->name('employees.grid');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/details', [EmployeeController::class, 'show'])->name('employees.details');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });

    // Department Routes
    Route::resource('departments', DepartmentController::class);

    // Designation Routes
    Route::resource('designations', DesignationController::class);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Account Routes
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account/deactivate', [AccountController::class, 'deactivate'])->name('account.deactivate');
    Route::delete('/account/delete', [AccountController::class, 'delete'])->name('account.delete');

    // User Management Routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    // Asset Routes
    Route::prefix('assets')->group(function () {
        // Categories routes must come first to avoid conflicts with assets/{id} route
        Route::get('/categories', [AssetCategoryController::class, 'index'])->name('assets.categories.index');
        Route::get('/categories/create', [AssetCategoryController::class, 'create'])->name('assets.categories.create');
        Route::post('/categories', [AssetCategoryController::class, 'store'])->name('assets.categories.store');
        Route::get('/categories/{category}', [AssetCategoryController::class, 'show'])->name('assets.categories.show');
        Route::get('/categories/{category}/edit', [AssetCategoryController::class, 'edit'])->name('assets.categories.edit');
        Route::put('/categories/{category}', [AssetCategoryController::class, 'update'])->name('assets.categories.update');
        Route::delete('/categories/{category}', [AssetCategoryController::class, 'destroy'])->name('assets.categories.destroy');
        
        // Assets resource routes
        Route::get('/', [AssetController::class, 'index'])->name('assets.index');
        Route::get('/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('/', [AssetController::class, 'store'])->name('assets.store');
        Route::get('/{asset}', [AssetController::class, 'show'])->name('assets.show');
        Route::get('/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::put('/{asset}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');
    });

    // Holiday Routes
    Route::resource('holidays', HolidayController::class);

    // Training Routes - Types routes must come first to avoid conflicts
    Route::prefix('training')->name('training.')->group(function () {
        Route::get('/types', [TrainingTypeController::class, 'index'])->name('types.index');
        Route::get('/types/create', [TrainingTypeController::class, 'create'])->name('types.create');
        Route::post('/types', [TrainingTypeController::class, 'store'])->name('types.store');
        Route::get('/types/{trainingType}', [TrainingTypeController::class, 'show'])->name('types.show');
        Route::get('/types/{trainingType}/edit', [TrainingTypeController::class, 'edit'])->name('types.edit');
        Route::put('/types/{trainingType}', [TrainingTypeController::class, 'update'])->name('types.update');
        Route::delete('/types/{trainingType}', [TrainingTypeController::class, 'destroy'])->name('types.destroy');
    });
    
    // Training resource routes (must come after types routes)
    Route::resource('training', TrainingController::class);
    Route::resource('trainers', TrainerController::class);

    // Interview Routes - Feedback routes must come first to avoid conflicts
    Route::prefix('interviews')->name('interviews.')->group(function () {
        Route::get('/feedback', [InterviewFeedbackController::class, 'index'])->name('feedback.index');
        Route::get('/feedback/create', [InterviewFeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [InterviewFeedbackController::class, 'store'])->name('feedback.store');
        Route::get('/feedback/{id}', [InterviewFeedbackController::class, 'show'])->name('feedback.show');
        Route::get('/feedback/{id}/edit', [InterviewFeedbackController::class, 'edit'])->name('feedback.edit');
        Route::put('/feedback/{id}', [InterviewFeedbackController::class, 'update'])->name('feedback.update');
        Route::delete('/feedback/{id}', [InterviewFeedbackController::class, 'destroy'])->name('feedback.destroy');
    });
    
    // Interview resource routes (must come after feedback routes)
    Route::resource('interviews', InterviewController::class);

    // Job Posting Routes
    Route::resource('jobs', JobPostingController::class);

    // Candidate Routes
    Route::resource('candidates', CandidateController::class);

    // Promotion Routes
    Route::resource('promotions', PromotionController::class);

    // Resignation Routes
    Route::resource('resignations', ResignationController::class);

    // Termination Routes
    Route::resource('terminations', TerminationController::class);
});
