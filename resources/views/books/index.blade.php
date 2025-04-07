<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Library Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div id="success-message" class="mb-4 p-4 bg-green-500 text-white rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div id="error-message" class="mb-4 p-3 bg-red-600 text-white rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <script>
                       setTimeout(function() {
                        document.getElementById('success-message')?.remove();
                        document.getElementById('error-message')?.remove();
                       }, 10000);
                    </script> 
                 

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('books.create') }}" class="px-4 py-3 bg-green-600 text-white rounded-md mr-4">
                            Add a New Book
                        </a>
                    @endif

                    <a href="{{ route('borrows.index') }}" class="px-4 py-3 bg-green-600 text-white rounded-md mb-6 inline-block">
                        See your borrowed books
                    </a>

                    <h1 class="text-2xl font-bold mb-4">Library Books</h1>

                    @foreach ($books as $book)
                        <div class="mb-4 p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <p class="text-lg font-semibold">{{ $book->title }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">By {{ $book->author }}</p>
                            <p class="text-sm text-gray-600">ISBN: {{ $book->isbn }}</p>
                            <p class="text-sm text-gray-600">Copies available: {{ $book->copies }}</p>
                            <p class="text-sm text-gray-600">Category: {{$book->category->name ?? ''}}</p>
                            <form method="POST" action="{{ route('borrow.store') }}" class="mt-2">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Borrow</button> 
                            </form>
                            @if(auth()->user()->isAdmin())
                                @if(!$book->is_archived)
                                <form method="POST" action="{{route('books.archive', $book->id)}}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Archive Book</button>
                                </form>
                                @else
                                <form method="POST" action="{{route('books.unarchive', $book->id)}}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">unarchive Book</button>
                                </form>
                                @endif
                            @endif
                            <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:underline mt-4 inline-block">View Details</a>
                        </div>
                    @endforeach

                    <div class="mt-6 flex justify-center">
                        {{ $books->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>

