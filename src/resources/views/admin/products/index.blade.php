@extends('admin.layouts.default')

@section('title', 'Products')

@section('page-title', 'Products')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center space-x-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search products..."
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
                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:underline">
                    Clear
                </a>
            @endif
        </form>

        <a href="{{ route('admin.products.new') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Product</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ optional($product->store)->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $product->created_at?->format('d/m/Y H:i a') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <x-admin.delete-button :action="route('admin.products.delete', ['product' => $product->id])">
                                Delete
                            </x-admin.delete-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection

