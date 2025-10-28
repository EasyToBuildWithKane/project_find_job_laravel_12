<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyAbout\CompanyProfileController;
use App\Http\Controllers\Admin\CompanyAbout\CompanyTeamMemberController;
use App\Http\Controllers\Admin\CompanyAbout\WhyChooseUsController;
use App\Http\Controllers\Admin\Pricing\PricingPlanController;
use App\Http\Controllers\Admin\Content\BlogController as AdminContentBlogController;
use App\Http\Controllers\Admin\Content\CounterController as AdminContentCounterController;
use App\Http\Controllers\Admin\Content\HeroController as AdminContentHeroController;
use App\Http\Controllers\Admin\Content\LearnMoreController as AdminContentLearnMoreController;
use App\Http\Controllers\Admin\JobManagement\CountryController;
use App\Http\Controllers\Admin\JobManagement\StateController;
use App\Http\Controllers\Admin\JobManagement\CityController;
use App\Http\Controllers\Admin\JobManagement\LanguageController;
use App\Http\Controllers\Admin\JobManagement\SkillController;
use App\Http\Controllers\Admin\JobManagement\ProfessionController;
use App\Http\Controllers\Admin\JobManagement\JobCategoryController;
use App\Http\Controllers\Admin\JobManagement\JobRoleController;
use App\Http\Controllers\Admin\JobManagement\JobTypeController;
use App\Http\Controllers\Admin\JobManagement\SalaryTypeController;
use App\Http\Controllers\Admin\JobManagement\EducationController;
use App\Http\Controllers\Admin\JobManagement\JobExperienceController;
use App\Http\Controllers\Admin\JobManagement\JobController;
use App\Http\Controllers\Admin\JobManagement\TagController;
use App\Http\Controllers\Admin\JobManagement\BenefitsController;
use App\Http\Controllers\Admin\JobManagement\JobTagController;
use App\Http\Controllers\Admin\JobManagement\JobSkillsController;
use App\Http\Controllers\Admin\JobManagement\JobBenefitsController;
use App\Http\Controllers\Admin\JobManagement\CompanyController;

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
                    Route::post('/remove_image/{id}', 'removeImage')->name('remove_image');
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
        Route::controller(AdminContentBlogController::class)
            ->prefix('content/blog')
            ->name('content.blog.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        Route::controller(AdminContentCounterController::class)
            ->prefix('content/counter')
            ->name('content.counter.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        Route::controller(AdminContentHeroController::class)
            ->prefix('content/hero')
            ->name('content.hero.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        Route::controller(AdminContentLearnMoreController::class)
            ->prefix('content/learn-more')
            ->name('content.learn_more.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });
        // Countries
        Route::controller(CountryController::class)
            ->prefix('countries')
            ->name('countries.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // States
        Route::controller(StateController::class)
            ->prefix('states')
            ->name('states.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // Cities
        Route::controller(CityController::class)
            ->prefix('cities')
            ->name('cities.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Languages
        Route::controller(LanguageController::class)
            ->prefix('languages')
            ->name('languages.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Skills
        Route::controller(SkillController::class)
            ->prefix('skills')
            ->name('skills.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Professions
        Route::controller(ProfessionController::class)
            ->prefix('professions')->name('professions.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Job Categories
        Route::controller(JobCategoryController::class)
            ->prefix('job-categories')
            ->name('job_categories.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Job Roles
        Route::controller(JobRoleController::class)
            ->prefix('job-roles')
            ->name('job_roles.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Job Types
        Route::controller(JobTypeController::class)
            ->prefix('job-types')
            ->name('job_types.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Salary Types
        Route::controller(SalaryTypeController::class)
            ->prefix('salary-types')
            ->name('salary_types.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Education
        Route::controller(EducationController::class)
            ->prefix('education')
            ->name('education.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Job Experiences
        Route::controller(JobExperienceController::class)
            ->prefix('job-experiences')
            ->name('job_experiences.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Jobs
        Route::controller(JobController::class)
            ->prefix('jobs')->name('jobs.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Tags
        Route::controller(TagController::class)
            ->prefix('tags')
            ->name('tags.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Benefits
        Route::controller(BenefitsController::class)
            ->prefix('benefits')
            ->name('benefits.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Job Tags
        Route::controller(JobTagController::class)
            ->prefix('job-tags')
            ->name('job_tags.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Job Skills
        Route::controller(JobSkillsController::class)
            ->prefix('job-skills')
            ->name('job_skills.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Job Benefits
        Route::controller(JobBenefitsController::class)
            ->prefix('job-benefits')
            ->name('job_benefits.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // ===== Companies =====
        Route::controller(CompanyController::class)
            ->prefix('companies')
            ->name('companies.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // ===== Pricing Plan =====
        Route::prefix('pricing')
            ->name('pricing.')
            ->group(function () {
            Route::controller(PricingPlanController::class)
                ->prefix('pricing-plan')
                ->name('pricing_plan.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::delete('/destroy/{id}', 'destroy')->name('destroy');
                });
        });

    });


require __DIR__ . '/auth.php';