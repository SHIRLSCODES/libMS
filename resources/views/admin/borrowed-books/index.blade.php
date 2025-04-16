<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Borrowed Books</h2>
    </x-slot>

    <div class="py-6 px-4">
        <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left  text-black dark:text-white">Book Title</th>
                    <th class="px-4 py-2 text-left text-black dark:text-white">Borrowed By</th>
                    <th class="px-4 py-2 text-left text-black dark:text-white">Borrowed At</th>
                    <th class="px-4 py-2 text-left text-black dark:text-white">Status</th>
                </tr>
            </thead>
            <tbody>dark:
                @forelse($borrows as $borrow)
                    <tr>
                        <td class="border-t px-4 py-2  text-blue dark:text-gray-300">{{ $borrow->book->title }}</td>
                        <td class="border-t px-4 py-2 text-blue dark:text-gray-300">{{ $borrow->user->name }} ({{ $borrow->user->email }})</td>
                        <td class="border-t px-4 py-2 text-blue dark:text-gray-300">{{ $borrow->borrowed_at->format('d M Y') }}</td>
                        <td class="border-t px-4 py-2">
                            @if($borrow->returned_at)
                                <span class="text-green-600">Returned</span>
                            @else
                                <span class="text-red-600">Not Returned</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">No borrowed books found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $borrows->links() }}
        </div>
    </div>
</x-app-layout>
