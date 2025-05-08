<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Admin</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" >Library Card Status</th>
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
                <td class="px-6 py-4 whitespace-nowrap ">
                    @if ($user->is_active)
                        <form action="{{ route('admin.deactivate', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm mb-6">
                                Deactivate
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.activate', $user->id) }}" method="POST" onsubmit="return confirm('activate this user?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm mb-6">
                                Activate
                            </button>
                        </form>
                        
                    @endif
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.edit', $user->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition duration-300">
                        Edit user
                    </a> 
                    @endif
                </td> 
                <td>
                    @if ($user->libraryCard)
                        @if ($user->hasActiveLibraryCard())
                            <span class="text-green-600">Active</span>
                        @else
                            <span class="text-red-600">Expired</span>
                        @endif
                    @else
                        <span class="text-gray-500">No Card</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>