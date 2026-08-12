<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\AdminCashflowController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminInventoryController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffOrderController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Locale Switch
|--------------------------------------------------------------------------
*/
Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/community/events/{slug}', [CommunityController::class, 'show'])->name('community.show');
Route::post('/community/events/{id}/register', [CommunityController::class, 'register'])->name('community.register');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/qr', [MenuController::class, 'qr'])->name('menu.qr');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submitContact'])->name('contact.submit');
Route::post('/feedback/submit', [ContactController::class, 'submitFeedback'])->name('feedback.submit');

Route::post('/favorites/toggle/{menuId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Public Order Page (no login required)
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

/*
|--------------------------------------------------------------------------
| Authenticated User Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Staff Portal Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff,admin'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffAttendanceController::class, 'index'])->name('dashboard');
    Route::post('/attendance/clock-in', [StaffAttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [StaffAttendanceController::class, 'clockOut'])->name('attendance.clock-out');

    // Food/Beverage Ordering
    Route::post('/orders', [StaffOrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/status', [StaffOrderController::class, 'updateStatus'])->name('orders.update-status');
});

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Inventory & raw materials
    Route::get('ingredients', [AdminInventoryController::class, 'ingredients'])->name('ingredients.index');
    Route::post('ingredients', [AdminInventoryController::class, 'storeIngredient'])->name('ingredients.store');
    Route::put('ingredients/{ingredient}', [AdminInventoryController::class, 'updateIngredient'])->name('ingredients.update');
    Route::delete('ingredients/{ingredient}', [AdminInventoryController::class, 'destroyIngredient'])->name('ingredients.destroy');
    Route::get('mixed-ingredients', [AdminInventoryController::class, 'mixed'])->name('mixed.index');
    Route::post('mixed-ingredients', [AdminInventoryController::class, 'storeMixed'])->name('mixed.store');
    Route::put('mixed-ingredients/{mixedIngredient}', [AdminInventoryController::class, 'updateMixed'])->name('mixed.update');
    Route::delete('mixed-ingredients/{mixedIngredient}', [AdminInventoryController::class, 'destroyMixed'])->name('mixed.destroy');
    Route::post('mixed-ingredients/{mixedIngredient}/produce', [AdminInventoryController::class, 'produceMixed'])->name('mixed.produce');
    Route::get('inventory-logs', [AdminInventoryController::class, 'logs'])->name('inventory.logs');
    Route::post('inventory-logs', [AdminInventoryController::class, 'storeLog'])->name('inventory.logs.store');
    Route::get('inventory-logs/export', [AdminInventoryController::class, 'exportLogs'])->name('inventory.logs.export');

    // Finance
    Route::get('cashflows/{type}', [AdminCashflowController::class, 'index'])->whereIn('type', ['income', 'expense'])->name('cashflows.index');
    Route::post('cashflows/{type}', [AdminCashflowController::class, 'store'])->whereIn('type', ['income', 'expense'])->name('cashflows.store');
    Route::put('cashflows/{cashflow}', [AdminCashflowController::class, 'update'])->name('cashflows.update');
    Route::delete('cashflows/{cashflow}', [AdminCashflowController::class, 'destroy'])->name('cashflows.destroy');
    Route::get('finance', [AdminCashflowController::class, 'summary'])->name('finance.summary');
    Route::get('finance/export', [AdminCashflowController::class, 'export'])->name('finance.export');
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');

    // Menu Management
    Route::resource('menus', AdminMenuController::class)->except(['show']);
    Route::post('menus/{menu}/toggle-availability', [AdminMenuController::class, 'toggleAvailability'])->name('menus.toggle-availability');

    // Event Management
    Route::resource('events', AdminEventController::class)->except(['show']);
    Route::get('events/{event}/participants', [AdminEventController::class, 'participants'])->name('events.participants');

    // Staff Management
    Route::resource('staff', AdminStaffController::class)->except(['show']);

    // User Management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/{user}/update-role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
    Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Attendance Management & Reports
    Route::get('attendances', [AdminAttendanceController::class, 'index'])->name('attendances.index');
    Route::get('attendances/export/pdf', [AdminAttendanceController::class, 'exportPdf'])->name('attendances.export.pdf');
    Route::get('attendances/export/excel', [AdminAttendanceController::class, 'exportExcel'])->name('attendances.export.excel');

    // Feedbacks & Contact Messages
    Route::get('feedbacks', [AdminFeedbackController::class, 'index'])->name('feedbacks.index');
    Route::post('feedbacks/{feedback}/toggle-status', [AdminFeedbackController::class, 'toggleFeedbackStatus'])->name('feedbacks.toggle-status');
    Route::post('messages/{message}/mark-read', [AdminFeedbackController::class, 'markMessageRead'])->name('messages.mark-read');

    // Website Settings & Gallery
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [AdminSettingController::class, 'updateSettings'])->name('settings.update');
    Route::post('settings/gallery', [AdminSettingController::class, 'storeGallery'])->name('settings.gallery.store');
    Route::delete('settings/gallery/{gallery}', [AdminSettingController::class, 'destroyGallery'])->name('settings.gallery.destroy');
});

require __DIR__.'/auth.php';
