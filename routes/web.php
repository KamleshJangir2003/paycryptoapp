<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\AdminUserController;

// Auth Routes
Route::get('/privacy-policy', fn() => view('privacy'))->name('privacy');
Route::get('/terms-conditions', fn() => view('terms'))->name('terms');

Route::middleware('guest')->group(function () {
    Route::get('/', fn() => view('welcome'))->name('home');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/otp', [AuthController::class, 'sendOtp'])->name('register.otp');
    Route::get('/register/verify', [AuthController::class, 'showVerify'])->name('register.verify');
    Route::post('/register/verify', [AuthController::class, 'verifyOtp'])->name('register.verify.post');
    Route::get('/register/complete', [AuthController::class, 'showComplete'])->name('register.complete');
    Route::post('/register/complete', [AuthController::class, 'completeRegister'])->name('register.complete.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes
Route::middleware(['auth', 'deposit.check'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::get('/deposit/create', [DepositController::class, 'create'])->name('deposit.create');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');

    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::get('/withdrawal/create', [WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('/withdrawal', [WithdrawalController::class, 'store'])->name('withdrawal.store');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/finance', [\App\Http\Controllers\FinanceReportController::class, 'finance'])->name('reports.finance');
    Route::get('/reports/adjustment', [\App\Http\Controllers\FinanceReportController::class, 'adjustment'])->name('reports.adjustment');

    Route::get('/referral', [\App\Http\Controllers\ReferralController::class, 'index'])->name('referral');

    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/poll', [\App\Http\Controllers\ChatController::class, 'poll'])->name('chat.poll');
    Route::get('/faq', fn() => view('help.faq'))->name('faq');
    Route::get('/tutorial', fn() => view('help.tutorial'))->name('tutorial');

    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/pin', [\App\Http\Controllers\SettingsController::class, 'updatePin'])->name('settings.pin');
    Route::get('/settings/password', fn() => view('settings.password'))->name('settings.password.page');
    Route::get('/settings/bank', fn() => view('settings.bank'))->name('settings.bank.page');
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/deposits', [AdminDepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits/{deposit}/approve', [AdminDepositController::class, 'approve'])->name('deposits.approve');
    Route::post('/deposits/{deposit}/reject', [AdminDepositController::class, 'reject'])->name('deposits.reject');

    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/complete', [AdminWithdrawalController::class, 'complete'])->name('withdrawals.complete');
    Route::post('/withdrawals/{withdrawal}/fail', [AdminWithdrawalController::class, 'fail'])->name('withdrawals.fail');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('users.toggle');

    Route::get('/payment-settings', [\App\Http\Controllers\Admin\AdminPaymentSettingController::class, 'index'])->name('payment.settings');
    Route::post('/payment-settings', [\App\Http\Controllers\Admin\AdminPaymentSettingController::class, 'update'])->name('payment.settings.update');

    Route::get('/reports/finance', [\App\Http\Controllers\Admin\AdminReportController::class, 'finance'])->name('reports.finance');
    Route::get('/reports/commissions', [\App\Http\Controllers\Admin\AdminReportController::class, 'commissions'])->name('reports.commissions');

    Route::get('/support', [\App\Http\Controllers\Admin\AdminSupportController::class, 'index'])->name('support.index');
    Route::post('/support/{ticket}/reply', [\App\Http\Controllers\Admin\AdminSupportController::class, 'reply'])->name('support.reply');
    Route::post('/support/{ticket}/close', [\App\Http\Controllers\Admin\AdminSupportController::class, 'close'])->name('support.close');
    Route::get('/chat', [\App\Http\Controllers\Admin\AdminChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [\App\Http\Controllers\Admin\AdminChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}/send', [\App\Http\Controllers\Admin\AdminChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{user}/poll', [\App\Http\Controllers\Admin\AdminChatController::class, 'poll'])->name('chat.poll');

    Route::post('/users/{user}/wallet-adjust', [\App\Http\Controllers\Admin\AdminWalletController::class, 'adjust'])->name('users.wallet.adjust');
});
