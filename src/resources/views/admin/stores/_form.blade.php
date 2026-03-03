<div>
    {!! html()->label('Store Name', 'name')
    ->class('block mb-2 text-sm font-medium text-gray-700') !!}
    {!! html()->text('name')
    ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
    ->required()
    ->placeholder('Enter store name') !!}
    @error('name')
    <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
    @enderror
</div>
