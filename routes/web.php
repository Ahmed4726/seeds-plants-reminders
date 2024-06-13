<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/template', [TemplateController::class, 'index'])->name('templates.index');

    Route::get('/templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::post('/templates/delete/{id}', [TemplateController::class, 'destroy'])->name('templates.delete');
    Route::get('/templates/edit/{id}', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/templates/update/{id}', [TemplateController::class, 'update'])->name('templates.update');


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
