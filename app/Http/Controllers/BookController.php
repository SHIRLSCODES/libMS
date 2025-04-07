<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveBookRequest;
use App\Http\Requests\SaveUpdateRequest;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->isAdmin()){
            $books = Book::paginate(5);
        }
        else{
            $books = Book::where('is_archived', false)->paginate(5);
        }
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view ('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveBookRequest $request)
    {
        $book = Book::create($request ->validated());

        return redirect()->route('books.index')->with('success','Book created successfully');
    }

    public function archiveBook(Request $request, string $id){
        $book =Book::findOrFail($id);

        $book->update([
            'is_archived' => true
        ]);

        return redirect()->route('books.index')->with('success', 'Book archived successfully');
    }

    
    public function unarchiveBook(Request $request, string $id){
        $book =Book::findOrFail($id);

        $book->update([
            'is_unarchived' => true
        ]);

        return redirect()->route('books.index')->with('success', 'Book brought back to life');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();

        return view ('books.edit', compact('book','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.index')->with('success','Book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
