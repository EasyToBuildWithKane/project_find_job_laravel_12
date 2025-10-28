<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Frontend\CompanyProfileController;
use App\Http\Controllers\API\Frontend\WhyChooseUsController;
use App\Http\Controllers\API\Frontend\CompanyTeamMemberController;
use App\Http\Controllers\API\Frontend\PricingPlanController;


Route::prefix('v1/')
    ->group(function () {
        // ===== FRONTEND / PUBLIC =====
        Route::prefix('frontend/')
            ->group(function () {

            Route::controller(CompanyProfileController::class)
                ->group(function () {
                    Route::get('company-profiles', 'index');

                });
            Route::controller(CompanyTeamMemberController::class)
                ->group(function () {
                    Route::get('company-team-member', 'index');

                });
            Route::controller(WhyChooseUsController::class)
                ->group(function () {
                    Route::get('why-choose-us', 'index');

                });
            Route::controller(PricingPlanController::class)
                ->group(function () {
                    Route::get('pricing-plan', 'index');

                });
        });






    });


