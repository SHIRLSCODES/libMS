<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            My Borrowed Books
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-900 text-white shadow-sm sm:rounded-lg p-6">

            @if (session('success'))
                <div id="success-message" class="mb-4 p-3 bg-green-600 text-white rounded-md">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div id="error-message" class="mb-4 p-3 bg-red-600 text-white rounded-md">{{ session('error') }}</div>
            @endif

        <script>
            setTimeout(function() {
                document.getElementById('success-message')?.remove();
                document.getElementById('error-message')?.remove();
            }, 10000);
        </script>

            <h3 class="text-xl font-semibold mb-4 text-white">Borrowed Books</h3>

            @if($borrows->isEmpty())
                <p class="text-gray-300">You have not borrowed any books yet.</p>
            @else
                <table class="w-full border-collapse border border-gray-600">
                    <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="border p-2">Title</th>
                            <th class="border p-2">Author</th>
                            <th class="border p-2">Borrowed Date</th>
                            <th class="border p-2">Returned Date</th>
                            <th class="border p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($borrows as $borrow)
                            <tr class="border border-gray-600">
                                <td class="border p-2 text-white">{{ $borrow->book->title }}</td>
                                <td class="border p-2 text-white">{{ $borrow->book->author }}</td>
                                <td class="border p-2 text-white">{{ $borrow->borrowed_at }}</td>
                               <td class="border p-2">
                                    {{ $borrow->returned_at ? $borrow->returned_at : 'Not returned yet' }}
                                </td>
                                <td class="border p-2">
                                    @if (!$borrow->returned_at)
                                        <form method="POST" action="{{ route('borrow.return', $borrow->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md">
                                                Return Book
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
