{{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('List Permissions') }}
</h2>
@can('create permission')
<a href="{{ route('permission.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">
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
                <form method="GET" action="{{ route('permission.index') }}">
                    <div class="flex items-center mb-4">
                        <input type="text" name="search" placeholder="Search permissions..." class="bg-gray-700 text-white px-4 py-2 rounded-md focus:outline-none focus:bg-gray-600" value="{{ request('search') }}">
                        <button type="submit" class="ml-3 bg-blue-500 text-white px-4 py-2 rounded-md">Search</button>
                        <a href="{{ route('permission.index') }}" class="ml-3 bg-red-500 text-white px-4 py-2 rounded-md">Clear</a>
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
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                {{ $permission->name }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                @can('edit permission')
                                <a href="{{ route('permission.edit', $permission->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                @endcan
                                @can('delete permission')
                                <a href="javascript:void(0);" onclick="deletePermission({{ $permission->id }})" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                                @endcan
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
                    {{ $permissions->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<x-slot name="script">
    <script type="text/javascript">
        function deletePermission(id) {
            if (confirm("Are you sure want to delete?")) {
                $.ajax({
                    url: '{{ route('
                    permission.destroy ') }}'
                    , type: 'delete'
                    , data: {
                        id: id
                    }
                    , dataType: 'json'
                    , headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    }
                    , success: function(response) {
                        window.location.href = '{{ route('
                        permission.index ') }}';
                    }
                });
            }
        }

    </script>
</x-slot>
</x-app-layout> --}}

@extends('backend.app')
@section('content')
<div class="main-content">

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Permissions</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index.html">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All User</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" method="GET" action="{{ route('permission.index') }}">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="search" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('permission.create') }}"><i class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td class="pname">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="#">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
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
                    </div>
                    {{ $permissions->appends(request()->query())->links() }}
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                </div>
            </div>
        </div>
    </div>


    @endsection
