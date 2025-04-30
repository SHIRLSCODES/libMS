<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           {{ "Edit User "}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.update', $user->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="name">
                                Name
                            </label>
                            <input type="text" id="title" value="{{ old('name', $user->name) }}" name="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-black dark:text-black" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="email">
                                Email
                            </label>
                            <input type="text" id="author" value="{{ old('email', $user->email) }}" name="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-black dark:text-black" required>
                        </div>


                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_admin" id= "is_admin" value="1" class="form-checkbox text-indigo-600"  {{ $user->is_admin ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">is user an Admin</span>
                            </label>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                            Save
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
