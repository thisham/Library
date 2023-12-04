<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Select2Controller;
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
        Route::get('', 'index')->name('admin.category.index');
        Route::get('add', 'create')->name('admin.category.create');
        Route::post('add', 'store')->name('admin.category.store');
        Route::get('edit/{id}', 'edit')->name('admin.category.edit');
        Route::put('edit/{id}', 'update')->name('admin.category.update');
        Route::delete('destroy/{id}', 'destroy')->name('admin.category.destroy');
    });

    Route::controller(AuthorController::class)->prefix('author')->group(function () {
        Route::get('', 'index')->name('admin.author.index');
        Route::get('add', 'create')->name('admin.author.create');
        Route::post('add', 'store')->name('admin.author.store');
        Route::get('edit/{id}', 'edit')->name('admin.author.edit');
        Route::put('edit/{id}', 'update')->name('admin.author.update');
        Route::delete('destroy/{id}', 'destroy')->name('admin.author.destroy');
    });

    Route::controller(BookController::class)->prefix('book')->group(function () {
        Route::get('', 'index')->name('admin.book.index');
        Route::get('add', 'create')->name('admin.book.create');
        Route::post('add', 'store')->name('admin.book.store');
        Route::get('edit/{id}', 'edit')->name('admin.book.edit');
        Route::put('edit/{id}', 'update')->name('admin.book.update');
        Route::delete('destroy/{id}', 'destroy')->name('admin.book.destroy');
    });

    Route::controller(LoanController::class)->prefix('loan')->group(function () {
        Route::get('', 'index')->name('admin.loan.index');
        Route::get('add', 'create')->name('admin.loan.create');
        Route::post('add', 'store')->name('admin.loan.store');
        Route::get('edit/{id}', 'edit')->name('admin.loan.edit');
        Route::put('edit/{id}', 'update')->name('admin.loan.update');
        Route::delete('destroy/{id}', 'destroy')->name('admin.loan.destroy');
    });

    Route::prefix('select2')->group(function () {
        Route::post('authors', [Select2Controller::class, 'getAuthors'])->name('admin.get.authors');
        Route::post('categories', [Select2Controller::class, 'getCategories'])->name('admin.get.categories');
        Route::post('books', [Select2Controller::class, 'getBooks'])->name('admin.get.books');
        Route::post('users', [Select2Controller::class, 'getUsers'])->name('admin.get.users');
    });
});

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/

Route::middleware(['auth', 'user-access:user'])->group(function () {
});
