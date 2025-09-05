<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyAbout\CompanyProfileController;

use Illuminate\Support\Facades\Route;


// ===== ADMIN / PROTECTED =====

Route::middleware(['auth.session'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'AdminDashboard'])
            ->name('dashboard');

        // Admin profile & password
        Route::controller(AdminController::class)->group(function () {
            // Profile
            Route::get('/profile', 'showProfile')->name('profile.show');
            Route::post('/profile/store', 'updateProfile')->name('profile.update');
            Route::post('/profile/remove-photo', 'removePhoto')->name('profile.remove-photo');
            // Password
            Route::get('/password/change', 'showChangePassword')->name('password.show');
            Route::post('/update/password', 'updatePassword')->name('update.password');
            // Logout
            Route::get('/logouts', 'logout')->name('logouts');
        });

        // Admin Company About
        // Company Profile
        Route::controller(CompanyProfileController::class)
            ->prefix('company_about')
            ->name('company_about.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{sectionKey}/edit', 'edit')->name('edit');
            Route::put('/{sectionKey}', 'update')->name('update');
        });

    });
// Bao gồm routes auth mặc định
require __DIR__ . '/auth.php';
