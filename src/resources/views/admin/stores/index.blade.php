@extends('admin.layouts.default')

@section('title', 'Stores')

@section('page-title', 'Stores')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('admin.stores.index') }}" class="flex items-center space-x-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search stores..."
                class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm"
            >
            <button type="submit" class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 text-sm">
                Filter
            </button>
            @if(request('search'))
                <a href="{{ route('admin.stores.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:underline">
                    Clear
                </a>
            @endif
        </form>

        <a href="{{ route('admin.stores.new') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Store</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($stores as $store)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $store->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $store->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $store->created_at->format('d/m/Y H:i a') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.stores.edit', ['store' => $store->id]) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <x-admin.delete-button :action="route('admin.stores.delete', ['store' => $store->id])">
                                Delete
                            </x-admin.delete-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No stores found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $stores->links() }}
    </div>
</div>
@endsection
