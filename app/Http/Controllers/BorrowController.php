<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Book;
use App\Events\BookBorrowed;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        
    $book = Book::findOrFail($request->book_id);

    if ($book->copies <= 0) {
        return redirect()->route('books.index')->with('error', 'No copies available for this book.');
    }

    $book->decrement('copies');

    $existingBorrow = Borrow::where('user_id', auth()->id())->where('book_id', $request->book_id)->first();

    if($existingBorrow){
        return redirect()->route('books.index')->with('error', 'You have already borrowed this book');
    }

        Borrow::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(3),
        ]);

        event(new BookBorrowed(auth()->user(), $book));

        return redirect()->route('books.index')->with('success', 'Book borrowed successfully!');
    }

    public function borrowed(){
        $borrows = Borrow::with('book')->where('user_id', auth()->id())->latest()->get();

        return view('borrows.index', compact('borrows'));
    }

    public function returnBook($id){
        $borrow = Borrow::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$borrow){
            return redirect()->route('borrows.index')->with('error', 'Invalid return request.');
        }
        if (!$borrow->fine_paid){
            return redirect()->route('borrows.index')->with('error', 'Pay your fine before you click return');
        }
        
        $book = Book::findOrFail($borrow->book_id);

        $borrow->update(['returned_at' => now()]);

        $book->increment('copies');

        return redirect()->route('borrows.index')->with('success', 'Book returned successfully!');
        
    }

    public function renewBorrow($id){
        $borrow = Borrow::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$borrow){
            return redirect()->route('borrows.index')->with('error', 'Invalid return request.');
        }
        if (!$borrow->fine_paid){
            return redirect()->route('borrows.index')->with('error', 'Pay your fine before you click renew');
        }

        $book = Book::findOrFail($borrow->book_id);

        $borrow->update(['borrowed_date' => now()]);
        $borrow->update(['due_date' => now()->addDays(1)]); 

        return redirect()->route('borrows.index')->with('success', 'Book renewed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
