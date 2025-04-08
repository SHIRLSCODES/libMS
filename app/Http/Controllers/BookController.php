<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveBookRequest;
use App\Http\Requests\SaveUpdateRequest;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();
    
        if (auth()->user()->isAdmin()) {
            $filter = $request->query('filter');
    
            if ($filter === 'mine') {
                $query->where('created_by', auth()->id());
            }
        } else {
            $query->where('is_archived', false);
        }
    
        if ($request->filled('category')) {
            $query->where('category_id', $request->query('category'));
        }
    
        $books = $query->paginate(5);
    
        $categories = Category::all();
    
        return view('books.index', compact('books', 'categories'));
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

        $book->created_by = auth()->id();
        $book->save();

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

    public function search(Request $request)
        {
            $query = $request->input('query');

            $books = Book::where('title', 'like', "%$query%")
                        ->orWhere('author', 'like', "%$query%")
                        ->paginate(5);

            return view('books.partials.book-list', compact('books'))->render();
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
