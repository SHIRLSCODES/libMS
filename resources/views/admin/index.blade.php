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

                    <h1 class="text-2xl font-bold mb-4 mt-4">Users</h1>

     
                       
                    <input type="text" id="user-search" placeholder="Search users by name or email..." class="mb-4 p-2 border border-gray-300 rounded w-full text-black">
                    
                    <div id="user-results">
                            @include('admin.partials.user-list', ['users' => $users])
                   </div>
                    
                    <div class="mt-6 flex justify-center">
                        {{ $users->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>

    <script>
        $('#user-search').on('keyup', $.debounce(3000,function() {
            
            let query = $(this).val();
            
            $.ajax({
                url: '{{ route('admin.search') }}',
                type: 'GET',
                data: { query: query },
                success: function(data) {
                    $('#user-results').html(data);
                }
            });
        }));
    </script>
    

</x-app-layout>

