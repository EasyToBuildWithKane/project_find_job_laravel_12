<?php

use App\Http\Middleware\AdminRoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // --- Admin routes ---
            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         *  Global Middleware
         * Dành cho mọi request (CORS, maintenance, trusted proxies,...)
         */
        $middleware->prepend(HandleCors::class);

        /**
         * Middleware Aliases
         * Có thể gọi bằng tên ngắn gọn trong route
         */
        $middleware->alias([
            'role' => AdminRoleMiddleware::class,
        ]);

        /**
         * API Middleware Group
         * Dành cho API có authentication/stateful session
         */
        $middleware->appendToGroup('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
    })
    ->withProviders([
        // Đặt service provider custom
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        /**
         * Exception Handling
         * - Dùng chung cho tất cả request (Web + API)
         * - Ẩn thông tin nhạy cảm trên production
         */
         $exceptions->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        });
    })
    ->booted(function () {
        /**
         * Đặt logic sau khi app khởi động (VD: logging custom, event boot,...)
         */
    })
    ->create();
