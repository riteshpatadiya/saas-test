@extends('admin.layouts.default')

@section('title', 'Product Variants')

@section('page-title', 'Product Variants')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('admin.product-variants.index') }}" class="flex flex-wrap items-center gap-3">
            <input
                type="text"
                name="sku"
                value="{{ request('sku') }}"
                placeholder="Search SKU..."
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
            <select
                name="product_id"
                class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm"
            >
                <option value="">All products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected((string) request('product_id') === (string) $product->id)>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            <select
                name="status"
                class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm"
            >
                <option value="">All statuses</option>
                <option value="ACTIVE" @selected(request('status') === 'ACTIVE')>Active</option>
                <option value="INACTIVE" @selected(request('status') === 'INACTIVE')>Inactive</option>
            </select>
            <button type="submit" class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 text-sm">
                Filter
            </button>
            @if(request()->hasAny(['sku', 'store_id', 'product_id', 'status']) && (request('sku') || request('store_id') || request('product_id') || request('status')))
                <a href="{{ route('admin.product-variants.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:underline">
                    Clear
                </a>
            @endif
        </form>

        <a href="{{ route('admin.product-variants.new') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Product Variant</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($variants as $variant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $variant->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $variant->sku }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ optional($variant->product)->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ optional($variant->store)->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($variant->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $variant->status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $variant->created_at?->format('d/m/Y H:i a') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.product-variants.edit', ['variant' => $variant->id]) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <x-admin.delete-button :action="route('admin.product-variants.delete', ['variant' => $variant->id])">
                                Delete
                            </x-admin.delete-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No product variants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $variants->links() }}
    </div>
</div>
@endsection

