<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



 Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create')->middleware('is_admin');
    Route::get('/books/{book}/show', [BookController::class, 'show'])->name('books.show');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit')->middleware('is_admin');
    Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.update')->middleware('is_admin');

    Route::post('/books', [BookController::class, 'store'])->name('books.store')->middleware('is_admin');
    Route::patch('/books/{id}/archive', [BookController::class, 'archiveBook'])->name('books.archive');
    Route::patch('/books/{id}/unarchive', [BookController::class, 'unarchiveBook'])->name('books.unarchive');

    Route::post('/borrow',[BorrowController::class, 'store'])->name('borrow.store');

    Route::get('/borrows', [BorrowController::class, 'borrowed'])->name('borrows.index');
    Route::patch('/borrow/{id}/return', [BorrowController::class, 'returnBook'])->name('borrow.return');
 });

require __DIR__.'/auth.php';

