

@foreach ($books as $book)
<div class="mb-4 p-4 border border-gray-300 dark:border-gray-600 rounded-lg">

    <p class="text-lg font-semibold">{{ $book->title }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-400">By {{ $book->author }}</p>
    <p class="text-sm text-gray-600">ISBN: {{ $book->isbn }}</p>
    <p class="text-sm text-gray-600">Copies available: {{ $book->copies }}</p>
    <p class="text-sm text-gray-600">Category: {{$book->category->name ?? ''}}</p>
    @if(auth()->user()->isAdmin())
    <p class="text-sm text-gray-600">
        Created by: {{ $book->creator->name ?? 'N/A' }}
    </p>    
    @endif
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

