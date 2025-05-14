<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LibraryCardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



 Route::middleware(['auth', 'is_active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin', [UserController::class, 'index'])->name('admin.index')->middleware('is_admin');
    Route::get('/admin/create', [UserController::class, 'create'])->name('admin.create')->middleware('is_admin');
    Route::post('/admin', [UserController::class, 'store'])->name('admin.store')->middleware('is_admin');
    Route::patch('/admin/{id}/deactivate', [UserController::class, 'deactivate'])->name('admin.deactivate');
    Route::patch('/admin/{id}/activate', [UserController::class, 'activate'])->name('admin.activate');
    Route::get('/admin/search', [UserController::class, 'search'])->name('admin.search');
    Route::get('/admin/borrowed-books', [UserController::class, 'borrowedBooks'])->name('borrowed-books.index');
    Route::get('/admin/{user}/edit', [UserController::class, 'edit'])->name('admin.edit')->middleware('is_admin');
    Route::patch('/admin/{user}/update', [UserController::class, 'update'])->name('admin.update')->middleware('is_admin');
    Route::get('/admin/feedback', [FeedbackController::class, 'index'])->name('admin.feedback.index')->middleware('is_admin');

    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create')->middleware('is_admin');
    Route::get('/books/{book}/show', [BookController::class, 'show'])->name('books.show');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit')->middleware('is_admin');
    Route::patch('/books/{book}/update', [BookController::class, 'update'])->name('books.update')->middleware('is_admin');

    Route::post('/books', [BookController::class, 'store'])->name('books.store')->middleware('is_admin');
    Route::patch('/books/{id}/archive', [BookController::class, 'archiveBook'])->name('books.archive');
    Route::patch('/books/{id}/unarchive', [BookController::class, 'unarchiveBook'])->name('books.unarchive');

    Route::post('/borrow',[BorrowController::class, 'store'])->name('borrow.store')->middleware(['has_library_card', 'has_outstanding_fines']);
    Route::get('/borrows', [BorrowController::class, 'borrowed'])->name('borrows.index')->middleware('has_library_card');
    Route::patch('/borrows/{id}/renew', [BorrowController::class, 'renewBorrow'])->name('borrow.renew')->middleware('has_library_card');
    Route::patch('/borrow/{id}/return', [BorrowController::class, 'returnBook'])->name('borrow.return')->middleware('has_library_card');

    Route::get('/library-card/subscribe', [LibraryCardController::class, 'showSubscribeForm'])->name('library-card.subscribe');
    Route::get('/library-card/renew', [LibraryCardController::class, 'showRenewForm'])->name('library-card.renew');

    Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
    Route::get('/pay-fine/{borrow}', [PaymentController::class, 'payFine'])->name('pay.fine');
 });
    Route::get('/pay-fine/callback/{borrow}', [PaymentController::class, 'fineCallback'])->name('pay.fine.callback');
    Route::get('/paystack/callback', [PaymentController::class, 'handleGatewayCallback'])->name('paystack.callback');
require __DIR__.'/auth.php';

