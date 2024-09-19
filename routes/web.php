<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role !== 'regular') {
        return redirect('/admin-dashboard'); // Redirect administrators away
    }

    return view('dashboard'); // Load the regular user dashboard
})->middleware(['auth', 'verified'])->name('dashboard');


// profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// New route for indication reports
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/reports', [ReportController::class, 'showIndicationReports'])->name('reports.indication');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin-dashboard', function () {
        // Check if the user is an administrator
        if (Auth::check() && Auth::user()->role === 'administrator') {
            return view('admin.dashboard');
        }
        return redirect('/')->with('error', 'Access Denied');
    })->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');

    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');

    Route::get('/admin/users/{id}/convert', [UserController::class, 'convert'])->name('admin.users.convert');

    Route::get('/admin/users/{id}/undo-convert', [UserController::class, 'undoConvert'])->name('admin.users.undoConvert');




    Route::get('/admin/settings', function () {
        // Check if the user is an administrator
        if (Auth::check() && Auth::user()->role === 'administrator') {
            return 'Site Settings Page';
        }
        return redirect('/')->with('error', 'Access Denied');
    })->name('admin.settings');

    Route::get('/admin/reports', function () {
        // Check if the user is an administrator
        if (Auth::check() && Auth::user()->role === 'administrator') {
            return 'Reports Page';
        }
        return redirect('/')->with('error', 'Access Denied');
    })->name('admin.reports');
});



require __DIR__ . '/auth.php';
