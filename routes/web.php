<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Admin\Categories\ManageCategories;
use App\Http\Livewire\OfficerManageProducts;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Customers\ManageCustomers;
use App\Http\Livewire\Admin\Customers\CreateCustomer;
use App\Http\Livewire\Admin\Customers\EditCustomer;
use App\Http\Livewire\Admin\Users\ManageUsers;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware(['auth', 'admin'])->prefix('admin/manage-users')->group(function () {
    Route::get('/', ManageUsers::class)->name('admin.manage-users.index');
    Route::get('/create', [UserController::class, 'create'])->name('admin.manage-users.create');
    Route::post('/', [UserController::class, 'store'])->name('admin.manage-users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.manage-users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('admin.manage-users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.manage-users.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin/manage-product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('admin.manage-products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('admin.manage-products.create');
    Route::post('/', [ProductController::class, 'store'])->name('admin.manage-products.store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('admin.manage-products.edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('admin.manage-products.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('admin.manage-products.destroy');
    Route::get('/history', [ProductController::class, 'history'])->name('admin.manage-products.history');
    Route::put('/restore/{id}', [ProductController::class, 'restore'])->name('admin.manage-products.restore');
    Route::get('/filter', [ProductController::class, 'filter'])->name('admin.manage-products.filter');

});
Route::middleware(['auth', 'admin'])->prefix('admin/manage-category')->group(function () {
    Route::get('/',ManageCategories::class)->name('admin.manage-category.index');
    // Route::get('/create', [CategoryController::class, 'create'])->name('admin.manage-category.create');
    // Route::post('/', [CategoryController::class, 'store'])->name('admin.manage-category.store');
    // Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('admin.manage-category.edit');
    // Route::put('/{id}', [CategoryController::class, 'update'])->name('admin.manage-category.update');
    // Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('admin.manage-category.destroy');

});

Route::middleware(['auth'])->prefix('penjualan')->group(function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('admin.penjualan.index');
    Route::get('/create', [PenjualanController::class, 'create'])->name('admin.penjualan.create');
    Route::post('/store', [PenjualanController::class, 'store'])->name('admin.penjualan.store');
    Route::get('/invoice/{id}', [PenjualanController::class, 'printInvoice'])->name('admin.penjualan.invoice');
    Route::get('/detail/{id}', [PenjualanController::class, 'detail'])->name('admin.penjualan.detail');
    Route::get('/show/{id}', [PenjualanController::class, 'show'])->name('admin.penjualan.show');

});

Route::middleware(['auth', 'admin'])->prefix('admin/customers')->group(function () {
    Route::get('/', ManageCustomers::class)->name('admin.customers.index');
    // Route::get('/create', CreateCustomer::class)->name('admin.customers.create');
    // Route::get('/edit/{id}', EditCustomer::class)->name('admin.customers.edit');
});

Route::middleware(['auth', 'officer'])->group(function () {
    Route::get('/officer/manage-products', OfficerManageProducts::class)->name('officer.manage-products');
});









require __DIR__.'/auth.php';
