<?php

use App\Http\Controllers\Admin\RepositoryController;
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

    Route::resource('repositories', RepositoryController::class)->only('show')->middleware('can:view,repository');

    Route::redirect('/admin', '/admin/repositories')->name('admin');
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::resource('repositories', RepositoryController::class)->only('index', 'store', 'destroy');
    });
});
