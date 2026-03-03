@extends('store.layouts.default')

@section('title', 'Variant Inventory')

@section('page-title', 'Variant Inventory')

@section('content')
<div class="container mx-auto space-y-6">
    <div>
        <a href="{{ route('store.inventories.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to all inventory</a>
    </div>

    <div class="bg-white rounded shadow p-6 space-y-6">
        <div>
            <h2 class="text-lg font-semibold mb-1">Variant Details</h2>
            <p class="text-sm text-gray-600">
                SKU: <span class="font-mono">{{ $variant->sku }}</span> <br />
                Product: {{ optional($variant->product)->name }}
            </p>
        </div>

        <div class="overflow-x-auto bg-white rounded border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($locations as $location)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $location->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $locationStocks[$location->id] ?? 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                No locations found for this store.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($locations->isNotEmpty())
            <div class="border-t pt-6 space-y-8">
                <div>
                    <h3 class="text-md font-semibold mb-4">Adjust Stock</h3>
                    {!! html()->form('POST', route('store.inventories.adjust'))
                        ->class('space-y-4')
                        ->open() !!}

                        @csrf
                        {!! html()->hidden('product_variant_id')->value($variant->id) !!}

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                {!! html()->label('Location', 'store_location_id')
                                    ->class('block mb-2 text-sm font-medium text-gray-700') !!}
                                {!! html()->select('store_location_id', $locations->pluck('name', 'id'))
                                    ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
                                    ->required()
                                    ->placeholder('Select location') !!}
                                @error('store_location_id')
                                <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                {!! html()->label('Mode', 'mode')
                                    ->class('block mb-2 text-sm font-medium text-gray-700') !!}
                                <div class="flex items-center space-x-4">
                                    <label class="inline-flex items-center text-sm">
                                        <input type="radio" name="mode" value="set" class="mr-1" checked>
                                        Set
                                    </label>
                                    <label class="inline-flex items-center text-sm">
                                        <input type="radio" name="mode" value="increment" class="mr-1">
                                        Increment
                                    </label>
                                    <label class="inline-flex items-center text-sm">
                                        <input type="radio" name="mode" value="decrement" class="mr-1">
                                        Decrement
                                    </label>
                                </div>
                                @error('mode')
                                <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                {!! html()->label('Quantity', 'quantity')
                                    ->class('block mb-2 text-sm font-medium text-gray-700') !!}
                                {!! html()->number('quantity')
                                    ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
                                    ->required()
                                    ->placeholder('Enter quantity') !!}
                                @error('quantity')
                                <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            {!! html()->label('Note (optional)', 'note')
                                ->class('block mb-2 text-sm font-medium text-gray-700') !!}
                            {!! html()->text('note')
                                ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
                                ->placeholder('Reason for adjustment (optional)') !!}
                            @error('note')
                            <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            {!! html()->button('Apply Adjustment')
                                ->type('submit')
                                ->class('px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition') !!}
                        </div>
                    {!! html()->form()->close() !!}
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-md font-semibold mb-4">Inventory History</h3>
                    <div class="overflow-x-auto bg-white rounded border">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity Change</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($history as $entry)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->created_at?->format('d/m/Y H:i a') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ optional($entry->storeLocation)->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->note ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No inventory history yet for this variant.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

