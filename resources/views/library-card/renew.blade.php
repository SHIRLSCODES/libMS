<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Renew Library Card') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-3xl font-bold mb-4">Renew Your Library Card</h1>

                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-4">
                        Your library card expired on <span class="font-semibold">{{ $card->expires_at->format('d M Y') }}</span>.
                    </p>

                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                        Renewal costs ₦5000 and extends validity for one month.
                    </p>

                    <form method="POST" action="{{ route('pay') }}">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition duration-300 text-lg font-semibold">
                            Renew for ₦5000 with Paystack
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
