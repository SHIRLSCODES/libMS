<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900">
        <div class="text-center">
            <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-8">
                Welcome to Smiles Library Management System
            </h1>

            <div class="mt-6 space-x-6">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-blue-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-6 py-3 bg-green-600 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-green-700 transition">
                    Register
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
