<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100 text-center">Send Your Feedback</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-500 text-white rounded-lg text-center">{{ session('success') }}</div>
        @endif

        @if(auth()->user()->isAdmin())
            <div class="mb-4 text-center">
                <a href="{{ route('admin.feedback.index') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                    See all feedbacks
                </a>
            </div>
        @endif

        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf
            <textarea name="message" class="w-full p-3 border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="5" 
                placeholder="Write your feedback here, we want to hear from you..." required></textarea>
            <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">
                Submit
            </button>
        </form>
    </div>
</x-app-layout>
