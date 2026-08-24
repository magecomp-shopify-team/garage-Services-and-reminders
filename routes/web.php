<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

// User routes (Shared base layout, but role-restricted)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Manager and Receptionist
    Route::middleware('role:Receptionist')->group(function() {
        Route::resource('customers', \App\Http\Controllers\User\CustomerController::class);
        Route::resource('service-reminders', \App\Http\Controllers\User\ServiceReminderController::class);
        Route::post('/service-reminders/{serviceReminder}/status', [\App\Http\Controllers\User\ServiceReminderController::class, 'updateStatus'])->name('service-reminders.updateStatus');
    });

    // Manager, Receptionist, and Mechanic
    Route::middleware('role:Receptionist,Mechanic')->group(function() {
        Route::resource('vehicles', \App\Http\Controllers\User\VehicleController::class);
        Route::get('/job-cards', [\App\Http\Controllers\User\JobCardController::class, 'index'])->name('job-cards.index');
        Route::get('/job-cards/create', [\App\Http\Controllers\User\JobCardController::class, 'create'])->name('job-cards.create');
        Route::post('/job-cards', [\App\Http\Controllers\User\JobCardController::class, 'store'])->name('job-cards.store');
        Route::get('/job-cards/{jobCard}', [\App\Http\Controllers\User\JobCardController::class, 'show'])->name('job-cards.show');
        Route::post('/job-cards/{jobCard}/status', [\App\Http\Controllers\User\JobCardController::class, 'updateStatus'])->name('job-cards.updateStatus');
        Route::post('/job-cards/{jobCard}/services', [\App\Http\Controllers\User\JobCardController::class, 'addService'])->name('job-cards.addService');
        Route::post('/job-cards/{jobCard}/parts', [\App\Http\Controllers\User\JobCardController::class, 'addPart'])->name('job-cards.addPart');
    });

    // Manager Only (Master Data)
    Route::middleware('role:Manager')->group(function() {
        Route::resource('services', \App\Http\Controllers\User\ServiceController::class);
        Route::resource('mechanics', \App\Http\Controllers\User\MechanicController::class);
        Route::resource('spare-parts', \App\Http\Controllers\User\SparePartController::class);
    });

    // Manager and Accountant
    Route::middleware('role:Accountant')->group(function() {
        Route::resource('invoices', \App\Http\Controllers\User\InvoiceController::class)->only(['index', 'show', 'store']);
        Route::resource('payments', \App\Http\Controllers\User\PaymentController::class)->only(['index', 'store']);
    });
});

// Admin Auth routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'create'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'store']);
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'destroy'])->name('admin.logout');
});

// Admin Authenticated routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Core routes
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('vehicles', \App\Http\Controllers\Admin\VehicleController::class);
    Route::get('/job-cards', [\App\Http\Controllers\Admin\JobCardController::class, 'index'])->name('job-cards.index');
    Route::get('/job-cards/create', [\App\Http\Controllers\Admin\JobCardController::class, 'create'])->name('job-cards.create');
    Route::post('/job-cards', [\App\Http\Controllers\Admin\JobCardController::class, 'store'])->name('job-cards.store');
    Route::get('/job-cards/{jobCard}', [\App\Http\Controllers\Admin\JobCardController::class, 'show'])->name('job-cards.show');
    Route::post('/job-cards/{jobCard}/status', [\App\Http\Controllers\Admin\JobCardController::class, 'updateStatus'])->name('job-cards.updateStatus');
    Route::post('/job-cards/{jobCard}/services', [\App\Http\Controllers\Admin\JobCardController::class, 'addService'])->name('job-cards.addService');
    Route::post('/job-cards/{jobCard}/parts', [\App\Http\Controllers\Admin\JobCardController::class, 'addPart'])->name('job-cards.addPart');
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('mechanics', \App\Http\Controllers\Admin\MechanicController::class);
    Route::resource('spare-parts', \App\Http\Controllers\Admin\SparePartController::class);
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class)->only(['index', 'show', 'store']);
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->only(['index', 'store']);
    Route::resource('service-reminders', \App\Http\Controllers\Admin\ServiceReminderController::class);
    Route::post('/service-reminders/{serviceReminder}/status', [\App\Http\Controllers\Admin\ServiceReminderController::class, 'updateStatus'])->name('service-reminders.updateStatus');
    Route::get('/reports', function() { return view('admin.reports.index'); })->name('reports.index');
    Route::get('/users', function() { return view('admin.users.index'); })->name('users.index');
    Route::get('/settings', function() { return view('admin.settings.index'); })->name('settings.index');
});

require __DIR__.'/auth.php';
