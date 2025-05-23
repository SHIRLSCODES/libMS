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
                            <th class="border px-2">Title</th>
                            <th class="border px-2">Author</th>
                            <th class="border px-2">Borrowed Date</th>
                            <th class="border px-2">Due Date</th>
                            <th class="border px-2">Returned Date</th>
                            <th class="border px-2">Actions</th>
                            <th class="border px-2">Status</th>
                            <th class="border px-2">Fine</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($borrows as $borrow)
                            <tr class="border border-gray-600">
                                <td class="border p-2 text-white">{{ $borrow->book->title }}</td>
                                <td class="border p-2 text-white">{{ $borrow->book->author }}</td>
                                <td class="border p-2 text-white">{{ $borrow->borrowed_at }}</td>
                                <td class="border p-2 text-white">{{ $borrow->due_date }}</td>
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

                                    @if (!$borrow->returned_at && $borrow->fine_amount == 0)
                                        <form method="POST" action="{{ route('borrow.renew', $borrow->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="mt-2 px-3 py-1 bg-green-600 text-white rounded-md">
                                                Renew Book for one day!
                                            </button>
                                        </form>
                                    @endif
        
                                    @if($borrow->fine_amount > 0)
                                        <a href="{{ route('pay.fine', $borrow->id) }}" class="inline-block mt-1 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Pay Fine</a>
                                    @else
                                        <span class="text-green-600 font-semibold">no fine</span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    @if($borrow->returned_at)
                                        Returned
                                        @elseif($borrow->due_date && now()->greaterThan($borrow->due_date))
                                        Overdue
                                    @else
                                        Borrowed
                                    @endif
                                </td>
                                <td class="border p-2">
                                    @if($borrow->due_date && is_null($borrow->returned_at) && now()->greaterThan($borrow->due_date))
                                         ₦{{ number_format($borrow->fine_amount) }}
                                    @else
                                        -
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
