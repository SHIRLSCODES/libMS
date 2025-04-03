<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-3xl font-bold mb-4">{{ $book->title }}</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-2"><strong>Author:</strong> {{ $book->author }}</p>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-2"><strong>Category:</strong> {{ $book->category->name ?? ''}}</p>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-2"><strong>Copies Available:</strong> {{ $book->copies }}</p>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6"><strong>ISBN:</strong> {{ $book->isbn }}</p>

                    <a href="{{ route('books.edit', $book->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition duration-300">
                        Edit Book
                    </a> 

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
