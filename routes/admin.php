<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyAbout\CompanyProfileController;
use App\Http\Controllers\Admin\CompanyAbout\CompanyTeamMemberController;
use App\Http\Controllers\Admin\CompanyAbout\WhyChooseUsController;

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
| Đây là khu vực chỉ dành cho tài khoản admin hợp lệ.
| Middleware `auth.session` có thể thay bằng `auth:admin` nếu có multi-guard.
| Mọi route đều được prefix bởi /admin trong bootstrap/app.php
*/

Route::middleware(['auth.session', 'role:admin'])
    ->group(function () {

        /**
         * Dashboard
         */
        Route::get('/dashboard', [DashboardController::class, 'AdminDashboard'])
            ->name('dashboard');

        /**
         *  Admin Profile & Password Management
         */
        Route::controller(AdminController::class)
            ->prefix('profile')
            ->name('profile.')
            ->group(function () {
                Route::get('/', 'showProfile')->name('show');
                Route::post('/', 'updateProfile')->name('update');
                Route::post('/remove-photo', 'removePhoto')->name('remove-photo');

                Route::get('/password/change', 'showChangePassword')->name('password.show');
                Route::post('/password/update', 'updatePassword')->name('password.update');

                Route::get('/logouts', 'logout')->name('logouts');
            });
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

        /**
         * Company About Section
         */
        Route::prefix('company_about')
            ->name('company_about.')
            ->group(function () {

                // Company Profile
                Route::controller(CompanyProfileController::class)
                    ->prefix('profile')
                    ->name('company_profile.')
                    ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/{id}/edit', 'edit')->name('edit');
                    Route::put('/{id}', 'update')->name('update');
                    Route::post('/remove_image/{id}', 'removeImage')->name('remove-image');
                });

                // Company Team Member
                Route::controller(CompanyTeamMemberController::class)
                    ->prefix('team_member')
                    ->name('company_team_member.')
                    ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/{id}/edit', 'edit')->name('edit');
                    Route::put('/{id}', 'update')->name('update');
                    Route::post('/remove_image/{id}', 'removeImage')->name('remove_image');
                });
               
                 // Why Choose Us
                Route::controller(WhyChooseUsController::class)
                    ->prefix('why_choose_us')
                    ->name('why_choose_us.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{id}/edit', 'edit')->name('edit');
                        Route::put('/{id}', 'update')->name('update');
                        Route::delete('/{id}', 'destroy')->name('destroy');
                        Route::post('/remove_image/{id}', 'removeImage')->name('remove_image');
                    });
            });
    });


require __DIR__ . '/auth.php';
