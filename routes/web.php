<?php

use App\Http\Controllers\Admin\RepositoryController;
use App\Http\Controllers\RepositoryContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');


    Route::middleware('can:view,repository')->group(function() {
        Route::resource('repositories', RepositoryController::class)->only('show');

        Route::prefix('repositories/{repository}')->name('repositories.content.')->group(function() {
            Route::get('{archetype}', [RepositoryContentController::class, 'index'])->name('index');
            Route::get('{archetype}/{slug}', [RepositoryContentController::class, 'edit'])->name('edit');
            Route::put('{archetype}/{slug}', [RepositoryContentController::class, 'update'])->name('update');
            Route::delete('{archetype}/{slug}', [RepositoryContentController::class, 'destroy'])->name('destroy');
        });
    });

    Route::redirect('/admin', '/admin/repositories')->name('admin');
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::resource('repositories', RepositoryController::class)->only('index', 'store', 'destroy');
    });
});
