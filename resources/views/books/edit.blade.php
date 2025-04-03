<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           {{ "Edit {$book->title} "}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('books.update', $book->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="title">
                                Book Title
                            </label>
                            <input type="text" id="title" value="{{ old('title', $book->title) }}" name="title" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-black dark:text-black" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="author">
                                Author
                            </label>
                            <input type="text" id="author" value="{{ old('author', $book->author) }}" name="author" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-black dark:text-black" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="isbn">
                                ISBN
                            </label>
                            <input type="text" id="isbn" value="{{ old('isbn', $book->isbn) }}" name="isbn" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-black dark:text-black" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="copies">
                                Copies
                            </label>
                            <input type="text" id="copies" value="{{ old('copies', $book->copies) }}" name="copies" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-black dark:text-black" required>
                        </div>

                        <div class="mb-4">
                            <label for="category_id">Choose a category:</label>
                            <select id="category_id" name="category_id" class="form-control text-black dark:text-black">
                                @foreach ($categories as $category)
                                    <option class="text-black dark:text-black" value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                            Save
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
