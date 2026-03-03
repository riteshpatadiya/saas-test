<div class="space-y-6">
    <div>
        {!! html()->label('Product Name', 'name')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->text('name')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Enter product name') !!}
        @error('name')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Description', 'description')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->textarea('description')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->placeholder('Enter description')
            ->rows(4) !!}
        @error('description')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>

