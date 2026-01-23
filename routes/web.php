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
});
