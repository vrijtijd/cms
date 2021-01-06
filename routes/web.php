<?php

use App\Http\Controllers\Admin\RepositoryController;
use App\Http\Controllers\PublishRepositoryController;
use App\Http\Controllers\RepositoryContentController;
use App\Http\Controllers\PreviewRepositoryController;
use App\Http\Controllers\RepositoryStaticFileController;
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

        Route::get('repositories/{repository}/preview', PreviewRepositoryController::class)->name('repositories.preview');
        Route::get('repositories/{repository}/preview/p/{path?}', RepositoryStaticFileController::class)->where('path', '(.*)');
        Route::get('repositories/{repository}/publish', PublishRepositoryController::class)->name('repositories.publish');

        Route::prefix('repositories/{repository}')->name('repositories.content.')->group(function() {
            Route::get('{archetype}', [RepositoryContentController::class, 'index'])->name('index');
            Route::post('{archetype}', [RepositoryContentController::class, 'store'])->name('store');
            Route::get('{archetype}/{slug}', [RepositoryContentController::class, 'edit'])->name('edit');
            Route::put('{archetype}/{slug}', [RepositoryContentController::class, 'update'])->name('update');
        });
    });

    Route::redirect('/admin', '/admin/repositories')->name('admin');
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::resource('repositories', RepositoryController::class)->only('index', 'store');
    });
});
