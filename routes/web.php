<?php

use App\Http\Controllers\Admin\RepositoryController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PreviewRepositoryController;
use App\Http\Controllers\PublishRepositoryController;
use App\Http\Controllers\RepositoryContentController;
use App\Http\Controllers\RepositoryPublicFileController;
use App\Http\Controllers\RepositoryUploadController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');

    Route::middleware('can:view,repository')->group(function () {
        Route::resource('repositories', RepositoryController::class)->only('show');

        Route::get('repositories/{repository}/preview', PreviewRepositoryController::class)->name('repositories.preview');
        Route::get('repositories/{repository}/preview/p/{path?}', RepositoryPublicFileController::class)->where('path', '(.*)')
                                                                                                        ->name('repositories.public-files.show');

        Route::get('repositories/{repository}/publish', PublishRepositoryController::class)->name('repositories.publish.form');
        Route::put('repositories/{repository}/publish', PublishRepositoryController::class)->name('repositories.publish');

        Route::prefix('repositories/{repository}')->name('repositories.uploads.')->group(function () {
            Route::get('uploads', [RepositoryUploadController::class, 'index'])->name('index');
            Route::get('uploads/{path}', [RepositoryUploadController::class, 'show'])->name('show');
        });

        Route::prefix('repositories/{repository}')->name('repositories.content.')->group(function () {
            Route::get('{archetypeSlug}', [RepositoryContentController::class, 'index'])->name('index');
            Route::post('{archetypeSlug}', [RepositoryContentController::class, 'store'])->name('store');
            Route::get('{archetypeSlug}/{slug}', [RepositoryContentController::class, 'edit'])->name('edit');
            Route::put('{archetypeSlug}/{slug}', [RepositoryContentController::class, 'update'])->name('update');
        });
    });

    Route::redirect('/admin', '/admin/repositories')->name('admin');
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('repositories', RepositoryController::class)->only('index', 'store', 'edit', 'update');
        Route::resource('users', UserController::class)->only('index', 'store');
        Route::resource('teams', TeamController::class)->only('index');
    });
});
