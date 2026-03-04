<div class="space-y-6">
    <div>
        {!! html()->label('Topic', 'topic')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->select('topic', $topics)
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('Select a topic') !!}
        @error('topic')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {!! html()->label('Endpoint URL', 'endpoint_url')
            ->class('block mb-2 text-sm font-medium text-gray-700') !!}
        {!! html()->text('endpoint_url')
            ->class('block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500')
            ->required()
            ->placeholder('https://example.com/webhooks/handler') !!}
        @error('endpoint_url')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    @isset($webhookSubscription)
    <div>
        <label class="flex items-center gap-3 cursor-pointer">
            {!! html()->checkbox('is_active', true)
                ->class('w-4 h-4 text-blue-600 border-gray-300 rounded') !!}
            <span class="text-sm font-medium text-gray-700">Active</span>
        </label>
        @error('is_active')
        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>
    @endisset
</div>
