<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.auth.login');
});

// Check client IP
Route::get('/check-ip', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'request_ip' => $request->ip(),
    ]);
})->name('check.ip');

// Check user session
Route::get('/check-session', function () {
    return response()->json([
        'logout' => !Auth::check(),
    ]);
})->name('check.session');

require __DIR__.'/auth.php';
