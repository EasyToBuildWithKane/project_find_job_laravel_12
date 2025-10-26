<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $requiredRole
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $requiredRole): Response
    {
        $user = $request->user();

        // --- Check Authentication ---
        if (!$user) {
            return $this->unauthenticatedResponse($request);
        }

        // --- Check Active Status ---
        if ($user->status !== 'active') {
            abort(403, __('Tài khoản không hoạt động.'));
        }

        // --- Check Role ---
        if (!$this->hasRequiredRole($user->role, $requiredRole)) {
            abort(403, __('Tài khoản không có quyền truy cập.'));
        }

        return $next($request);
    }

    /**
     * Determine if user has the required role.
     */
    protected function hasRequiredRole(string $userRole, string $requiredRole): bool
    {
        return Str::lower($userRole) === Str::lower($requiredRole);
    }

    /**
     * Handle unauthenticated user response.
     */
    protected function unauthenticatedResponse(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => __('Bạn chưa đăng nhập.')], 401);
        }

        return redirect()->route('login');
    }
}
