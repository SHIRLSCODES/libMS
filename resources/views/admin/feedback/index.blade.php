<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100 text-center">User Feedback</h2>

        <div class="overflow-x-auto">
            <table class="w-full border border-collapse border-gray-300 dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <th class="border px-4 py-2">User</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Feedback</th>
                        <th class="border px-4 py-2">Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                        <tr class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <td class="border px-4 py-2">{{ $feedback->user->name }}</td>
                            <td class="border px-4 py-2">{{ $feedback->user->email }}</td>
                            <td class="border px-4 py-2">{{ $feedback->message }}</td>
                            <td class="border px-4 py-2">{{ $feedback->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-600 dark:text-gray-300">No feedback submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
