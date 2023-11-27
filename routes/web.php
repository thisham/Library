<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
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

Auth::routes(['verify' => true]);
Route::get('/', [HomeController::class, 'index'])->name('home');

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/

Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [HomeController::class, 'admin'])->name('admin.dashboard');

    Route::controller(CategoryController::class)->prefix('category')->group(function () {
        Route::get('', 'index')->name('admin.category');
        Route::get('add', 'create')->name('admin.category.create');
        Route::post('add', 'store')->name('admin.category.store');
        Route::get('edit/{id}', 'edit')->name('admin.category.edit');
        Route::put('edit/{id}', 'update')->name('admin.category.update');
        Route::get('destroy/{id}', 'destroy')->name('admin.category.destroy');
    });

    Route::controller(AuthorController::class)->prefix('author')->group(function () {
        Route::get('', 'index')->name('admin.author');
        Route::get('add', 'create')->name('admin.author.create');
        Route::post('add', 'store')->name('admin.author.store');
        Route::get('edit/{id}', 'edit')->name('admin.author.edit');
        Route::put('edit/{id}', 'update')->name('admin.author.update');
        Route::get('destroy/{id}', 'destroy')->name('admin.author.destroy');
    });

    Route::controller(BookController::class)->prefix('book')->group(function () {
        Route::get('', 'index')->name('admin.book');
        Route::get('add', 'create')->name('admin.book.create');
        Route::post('add', 'store')->name('admin.book.store');
        Route::get('edit/{id}', 'edit')->name('admin.book.edit');
        Route::put('edit/{id}', 'update')->name('admin.book.update');
        Route::get('destroy/{id}', 'destroy')->name('admin.book.destroy');
    });
});

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/

Route::middleware(['auth', 'user-access:user'])->group(function () {
});
