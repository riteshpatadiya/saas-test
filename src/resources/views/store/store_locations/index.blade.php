@extends('store.layouts.default')

@section('title', 'Store Locations')

@section('page-title', 'Store Locations')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Locations</h2>
        <a href="{{ route('store.store_locations.new') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Location</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($storeLocations as $location)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $location->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $location->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $location->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('store.store_locations.edit', ['storeLocation' => $location->id]) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <x-admin.delete-button :action="route('store.store_locations.delete', ['storeLocation' => $location->id])">
                                Delete
                            </x-admin.delete-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No locations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $storeLocations->links() }}
    </div>
</div>
@endsection

