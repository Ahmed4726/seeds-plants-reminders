<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TemplateController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;

// use App\Http\Controllers\VerificationController;

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

// Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Route to handle email verification without requiring the user to be logged in
Route::get('/verify-email/{id}/{hash}', [VerificationController::class, 'verifyEmail'])->name('verify.email');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('verify-email');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password reset routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Custom email verification route
Route::get('/verify-email/{id}/{hash}', [VerificationController::class, 'verifyEmail'])->name('verify.email');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/template', [TemplateController::class, 'index'])->name('templates.index');

    Route::get('/templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::post('/templates/delete/{id}', [TemplateController::class, 'destroy'])->name('templates.delete');
    Route::get('/templates/edit/{id}', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/templates/update/{id}', [TemplateController::class, 'update'])->name('templates.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/cycles/create', [CycleController::class, 'chooseTemplate'])->name('cycles.chooseTemplate');
    Route::get('/cycles/edit/{id}', [CycleController::class, 'edit'])->name('cycles.edit');
    Route::put('/cycles/update/{id}', [CycleController::class, 'update'])->name('cycles.update');
    Route::post('/cycles/delete/{id}', [CycleController::class, 'destroy'])->name('cycles.destroy');
    Route::post('/cycles/select-template', [CycleController::class, 'selectTemplate'])->name('cycles.selectTemplate');
    Route::get('/cycles/create-no-template', [CycleController::class, 'createNoTemplate'])->name('cycles.createNoTemplate');
    Route::post('/cycles/store', [CycleController::class, 'store'])->name('cycles.store');
    Route::get('/cycles/confirmation', [CycleController::class, 'confirmation'])->name('cycles.confirmation');
    Route::post('/cycles/confirm', [CycleController::class, 'confirm'])->name('cycles.confirm');

    Route::get('/calendar', [CycleController::class, 'calendar'])->name('cycles.calendar');

    Route::get('verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');


    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

    Route::get('/tags/{tagId}/cycles', [CycleController::class, 'showCyclesByTag'])->name('cycles.byTag');

    // Add more routes that require authentication here
});
