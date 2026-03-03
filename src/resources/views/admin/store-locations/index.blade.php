@extends('admin.layouts.default')

@section('title', 'Store Locations')

@section('page-title', 'Store Locations')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('admin.store-locations.index') }}" class="flex flex-wrap items-center gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name or address..."
                class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm"
            >

            <select
                name="store_id"
                class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm"
            >
                <option value="">All stores</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @selected((string) request('store_id') === (string) $store->id)>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 text-sm">
                Filter
            </button>
            @if(request()->hasAny(['search', 'store_id']) && (request('search') || request('store_id')))
                <a href="{{ route('admin.store-locations.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:underline">
                    Clear
                </a>
            @endif
        </form>

        <a href="{{ route('admin.store-locations.new') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Store Location</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($locations as $location)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $location->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ optional($location->store)->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $location->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $location->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $location->created_at?->format('d/m/Y H:i a') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.store-locations.edit', ['store_location' => $location->id]) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <x-admin.delete-button :action="route('admin.store-locations.delete', ['store_location' => $location->id])">
                                Delete
                            </x-admin.delete-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No store locations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $locations->links() }}
    </div>
</div>
@endsection

