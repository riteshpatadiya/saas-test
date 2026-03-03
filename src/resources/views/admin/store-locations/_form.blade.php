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
        {!! html()->label('Location Name', 'name')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->text('name')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Enter location name') !!}
        @error('name')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Address', 'address')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->textarea('address')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->rows(3)
            ->placeholder('Enter address') !!}
        @error('address')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>

