<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/post', [HomeController::class, 'post'])->name('post.create');
    Route::post('/post', [HomeController::class, 'store'])->name('post.store');

    Route::get('/post/{id}/qr', [HomeController::class, 'generateQr'])->name('post.qr');
    Route::get('/post/{id}', [HomeController::class, 'view'])->name('post.view');
    Route::delete('post/{id}', [HomeController::class, 'destroy'])->name('post.destroy');

    Route::post('/payment/qr', [HomeController::class, 'generateQrPayment'])->name('payment.qr');
    Route::post('/transactions', [HomeController::class, 'storeTransactions'])->name('transactions.store');
    Route::get('/transactions', [HomeController::class, 'transactions'])->name('transactions');
    Route::get('/notifications', [HomeController::class, 'userNotifications'])->name('user.notifications');
    Route::post('/notifications/{id}/mark-as-read', [HomeController::class, 'markAsRead'])->name('user.markNotificationAsRead');

});

// Routes khusus untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
    Route::get('/admin/manage-users/add', [AdminController::class, 'addUser'])->name('admin.addUser');
    Route::post('/admin/manage-users/store', [AdminController::class, 'storeUser'])->name('admin.storeUser');
    Route::get('/admin/manage-users/{id}/view', [AdminController::class, 'viewUser'])->name('admin.viewUser');
    Route::get('/admin/manage-users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::post('/admin/manage-users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::delete('/admin/manage-users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/admin/transactions/{transactionId}/accept', [AdminController::class, 'acceptTransaction'])->name('admin.transactions.accept');
    Route::get('/admin/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::get('/admin/notifications/create', [AdminController::class, 'createNotification'])->name('admin.create-notification');
    Route::post('/admin/notifications/store', [AdminController::class, 'storeNotification'])->name('admin.notifications.store');
    Route::get('/admin/notifications/{id}/edit', [AdminController::class, 'editNotification'])->name('admin.notifications.edit');
    Route::post('/admin/notifications/{id}/update', [AdminController::class, 'updateNotification'])->name('admin.notifications.update');
    Route::delete('/admin/notifications/{id}', [AdminController::class, 'deleteNotification'])->name('admin.notifications.delete');

});

// Routes khusus untuk superadmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'superadminDashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin/manage-users', [SuperAdminController::class, 'manageUsers'])->name('superadmin.manageUsers');
    Route::get('/superadmin/manage-users/add', [SuperAdminController::class, 'addUser'])->name('superadmin.addUser');
    Route::post('/superadmin/manage-users/store', [SuperAdminController::class, 'storeUser'])->name('superadmin.storeUser');
    Route::get('/superadmin/manage-users/{id}/view', [SuperAdminController::class, 'viewUser'])->name('superadmin.viewUser');
    Route::get('/superadmin/manage-users/{id}/edit', [SuperAdminController::class, 'editUser'])->name('superadmin.editUser');
    Route::post('/superadmin/manage-users/{id}/update', [SuperAdminController::class, 'updateUser'])->name('superadmin.updateUser');
    Route::delete('/superadmin/manage-users/{id}', [SuperAdminController::class, 'deleteUser'])->name('superadmin.deleteUser');
    Route::get('/superadmin/transactions', [SuperAdminController::class, 'transactions'])->name('superadmin.transactions');
    Route::post('/superadmin/transactions/{transactionId}/accept', [SuperAdminController::class, 'acceptTransaction'])->name('superadmin.transactions.accept');
    Route::get('/superadmin/notifications', [SuperAdminController::class, 'notifications'])->name('superadmin.notifications');
    Route::get('/superadmin/notifications/create', [SuperAdminController::class, 'createNotification'])->name('superadmin.create-notification');
    Route::post('/superadmin/notifications/store', [SuperAdminController::class, 'storeNotification'])->name('superadmin.notifications.store');
    Route::get('/superadmin/notifications/{id}/edit', [SuperAdminController::class, 'editNotification'])->name('superadmin.notifications.edit');
    Route::post('/superadmin/notifications/{id}/update', [SuperAdminController::class, 'updateNotification'])->name('superadmin.notifications.update');
    Route::delete('/superadmin/notifications/{id}', [SuperAdminController::class, 'deleteNotification'])->name('superadmin.notifications.delete');
    Route::get('/superadmin/manage-admins', [SuperAdminController::class, 'manageAdmins'])->name('superadmin.manageAdmins');
    Route::get('/superadmin/manage-admins/add', [SuperAdminController::class, 'addAdmin'])->name('superadmin.addAdmin');
    Route::post('/superadmin/manage-admins/store', [SuperAdminController::class, 'storeAdmin'])->name('superadmin.storeAdmin');
    Route::get('/superadmin/manage-admins/{id}/edit', [SuperAdminController::class, 'editAdmin'])->name('superadmin.editAdmin');
    Route::post('/superadmin/manage-admins/{id}/update', [SuperAdminController::class, 'updateAdmin'])->name('superadmin.updateAdmin');
    Route::delete('/superadmin/manage-admins/{id}', [SuperAdminController::class, 'deleteAdmin'])->name('superadmin.deleteAdmin');
});

require __DIR__ . '/auth.php';
