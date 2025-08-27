<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Frontend\CompanyProfileController;

Route::prefix('v1')->group(function () {
    // ===== FRONTEND / PUBLIC =====
    Route::prefix('frontend/')
        ->name('frontend.company-profiles.')
        ->controller(CompanyProfileController::class)
        ->group(function () {
            Route::get('company-profiles', 'index')
                ->name('index');
        });


});
