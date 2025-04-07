<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div id="success-message" class="mb-4 p-4 bg-green-500 text-white rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div id="error-message" class="mb-4 p-3 bg-red-600 text-white rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <script>
                       setTimeout(function() {
                        document.getElementById('success-message')?.remove();
                        document.getElementById('error-message')?.remove();
                       }, 10000);
                    </script> 
                 

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.create') }}" class="px-4 py-3 bg-green-600 text-white rounded-md mr-4">
                            Add a New User
                        </a>
                    @endif

                    <h1 class="text-2xl font-bold mb-4 mt-4">Active Users</h1>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Admin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($user->is_active)
                                            <form action="{{ route('admin.deactivate', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Deactivate
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.activate', $user->id) }}" method="POST" onsubmit="return confirm('activate this user?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Activate
                                                </button>
                                            </form>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6 flex justify-center">
                        {{ $users->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>

