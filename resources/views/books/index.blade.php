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

                    <a href="{{ route('borrowed-books.index') }}" class="px-4 py-3 bg-green-600 text-white rounded-md mb-6 inline-block">
                        See borrowed books
                    </a>

                    <h1 class="text-2xl font-bold mb-4">Library Books</h1>


                    @if (auth()->user()->isAdmin())
                        <div class="flex space-x-4 mb-6">
                            <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">All Books</a>
                            <a href="{{ route('books.index', ['filter' => 'mine']) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">My Books</a>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('books.index') }}" class="mb-6">
                        <input type="hidden" name="filter" value="{{ request('filter') }}">

                        <label for="category" class="text-white font-semibold">Filter by Category:</label>

                        <select name="category" id="category" class="ml-2 p-2 rounded text-black">
                            <option value="" class="text-black">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }} class="text-black">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    
                        <button type="submit" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
                    </form>
             
                @if ($books->count())
                
                <input type="text" id="book-search" placeholder="Search books by title or author..." class="mb-4 p-2 border border-gray-300 rounded w-full text-black">
                <div id="book-results">
                    @include('books.partials.book-list', ['books' => $books])
                </div>


                    <div class="mt-6 flex justify-center">
                        {{ $books->withQueryString()->links() }}
                    </div>

                    @else
                    <div class="mt-6 p-4 bg-yellow-100 text-yellow-800 rounded shadow">
                        No books found for your filter. Try adjusting the category or view all books.
                    </div>
                @endif
    
                </div>
            </div>
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('#book-search').on('keyup', function() {
                let query = $(this).val();

                $.ajax({
                    url: '{{ route('books.search') }}',
                    type: 'GET',
                    data: { query: query },
                    success: function(data) {
                        $('#book-results').html(data);
                    }
                });
            });
        </script>

</x-app-layout>

