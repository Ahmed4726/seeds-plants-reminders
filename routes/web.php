<?php

use App\Http\Controllers\CycleController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\HomeController;
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


    Route::get('/cycles/create', [CycleController::class, 'chooseTemplate'])->name('cycles.chooseTemplate');
    Route::post('/cycles/select-template', [CycleController::class, 'selectTemplate'])->name('cycles.selectTemplate');
    Route::get('/cycles/create-no-template', [CycleController::class, 'createNoTemplate'])->name('cycles.createNoTemplate');
    Route::post('/cycles/store', [CycleController::class, 'store'])->name('cycles.store');
    Route::get('/cycles/confirmation', [CycleController::class, 'confirmation'])->name('cycles.confirmation');
    Route::post('/cycles/confirm', [CycleController::class, 'confirm'])->name('cycles.confirm');
    
    Route::get('/calendar', [CycleController::class, 'calendar'])->name('cycles.calendar');

    // Add more routes that require authentication here
});
