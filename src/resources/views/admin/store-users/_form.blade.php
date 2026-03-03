<div class="space-y-6">
    <div>
        {!! html()->label('Name', 'name')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->text('name')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Enter name') !!}
        @error('name')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Email', 'email')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->email('email')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Enter email') !!}
        @error('email')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Password', 'password')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->password('password')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->placeholder('Enter password') !!}
        @error('password')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
        @isset($user)
            <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password.</p>
        @endisset
    </div>

    <div>
        {!! html()->label('Store', 'store_id')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->select('store_id', $stores->pluck('name', 'id'))
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Select store') !!}
        @error('store_id')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>

