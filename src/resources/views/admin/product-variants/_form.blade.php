<div class="space-y-6">
    <div>
        {!! html()->label('Store', 'store_id')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->select('store_id', $stores->pluck('name', 'id'))
            ->id('store_id')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Select store') !!}
        @error('store_id')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Product', 'product_id')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        <select
            id="product_id"
            name="product_id"
            class="block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            required
            data-products-url-template="{{ route('admin.products.by-store', ['store' => '__STORE__']) }}"
        >
            <option value="">{{ __('Select product') }}</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id', isset($variant) ? $variant->product_id : null) == $product->id)>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        @error('product_id')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('SKU', 'sku')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->text('sku')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Enter SKU') !!}
        @error('sku')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Price', 'price')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->number('price')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Enter price') !!}
        @error('price')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Attributes (JSON)', 'attributes')
        ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->textarea('attributes')
        ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 font-mono text-sm')
        ->rows(4)
        ->placeholder('{"size": "L", "color": "Red"}')
        ->value(
        old(
        'attributes',
        isset($variant) && is_array($variant->attributes)
        ? json_encode($variant->attributes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        : ''
        )
        ) !!}
        @error('attributes')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Status', 'status')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->select('status', ['ACTIVE' => 'Active', 'INACTIVE' => 'Inactive'])
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Select status') !!}
        @error('status')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>
