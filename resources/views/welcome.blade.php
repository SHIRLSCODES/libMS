<x-guest-layout>
    <div class="flex items-center justify-center">
        <div class="text-center w-full">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 mt-24">
                Welcome to Smiles Library Services
            </h1>
    
            <div class="mt-24 space-x-4">
                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-blue-600 text-white text-base sm:text-lg font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-green-600 text-white text-base sm:text-lg font-semibold rounded-lg shadow hover:bg-green-700 transition">
                    Register
                </a>
            </div>
        </div>
    </div>    
</x-guest-layout>
