@extends('admin.layouts.default')

@section('title', 'Inventory')

@section('page-title', 'Inventory Management')

@section('content')
<div class="container mx-auto space-y-8">
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4">All Product Variant Stock</h2>
        <form method="GET" action="{{ route('admin.inventories.index') }}" class="flex flex-wrap items-center gap-3" id="inventoryFilterForm">
            <select
                name="store_id"
                id="storeFilter"
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
                id="productFilter"
                class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm"
            >
                <option value="">All products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected((string) request('product_id') === (string) $product->id)>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 text-sm">
                Filter
            </button>
        </form>

        <div class="mt-6 overflow-x-auto bg-white rounded border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($variantStocks as $row)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row->sku }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row->product_name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row->store_name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row->total_stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a
                                    href="{{ route('admin.inventories.show', ['variant' => $row->id]) }}"
                                    class="text-blue-600 hover:underline text-sm"
                                >
                                    View by locations
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No product variants found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $variantStocks->links() }}
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const storeSelect = document.getElementById('storeFilter');
        const productSelect = document.getElementById('productFilter');
        const form = document.getElementById('inventoryFilterForm');

        if (storeSelect && productSelect && form) {
            storeSelect.addEventListener('change', function () {
                // Reset product selection when store changes
                if (productSelect) {
                    productSelect.selectedIndex = 0;
                }
                form.submit();
            });
        }
    });
</script>
@endsection

