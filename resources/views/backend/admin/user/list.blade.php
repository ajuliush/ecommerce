<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('List Users') }}
            </h2>
            @can('create user')
            <a href="{{ route('user.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">
                Create
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form method="GET" action="{{ route('user.index') }}">
                        <div class="flex items-center mb-4">
                            <input type="text" name="search" placeholder="Search role..." class="bg-gray-700 text-white px-4 py-2 rounded-md focus:outline-none focus:bg-gray-600" value="{{ request('search') }}">
                            <button type="submit" class="ml-3 bg-blue-500 text-white px-4 py-2 rounded-md">Search</button>
                            <a href="{{ route('user.index') }}" class="ml-3 bg-red-500 text-white px-4 py-2 rounded-md">Clear</a>
                        </div>
                    </form>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Roles
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isNotEmpty())
                            @foreach ($users as $user)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                    {{ $user->name }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                    {{$user->email}}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                    {{ucfirst($user->roles->pluck('name')->implode(' ,'))}}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                    <div class="inline-flex space-x-2">
                                        @can('edit user')
                                        <a href="{{ route('user.edit', $user->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                        @endcan
                                        @can('delete user')
                                        <a href="javascript:void(0);" onclick="deleteUser({{ $user->id }})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                    {{ "No Data available" }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
         <script type="text/javascript">
            function deleteUser(id) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        url: '{{ route('user.destroy') }}', 
                        type: 'delete', 
                        data: {
                            id: id
                        }, 
                        dataType: 'json', 
                        headers: {
                           'x-csrf-token': '{{ csrf_token() }}'
                            }, 
                            success: function(response) {
                                    window.location.href = '{{ route('user.index') }}'
                                }});
                            }
                        }
        </script> 
    </x-slot>
</x-app-layout>
