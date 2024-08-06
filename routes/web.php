<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::middleware('redirectIfAuthenticated')->group(function () {
    Route::get('/', [AuthController::class, 'getRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'userRegister'])->name('post.register');
    Route::get('login', [AuthController::class, 'getLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'loginUser'])->name('user.login');
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:1')->group(function () {
        Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('invoice-list',[AdminController::class,'invoiceList'])->name('user.invoice');
    });
    Route::middleware('role:0')->group(function () {
        Route::get('user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::resource('invoice', InvoiceController::class);
        Route::get('/invoice/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');
        Route::get('/invoice/email/{id}', [InvoiceController::class, 'sendEmail'])->name('invoice.email');
    });
    Route::get('logout', [AuthController::class, 'userLogout'])->name('user.logout');
});
