@extends('store.layouts.default')

@section('title', 'Edit Webhook Subscription')

@section('page-title', 'Edit Webhook Subscription')

@section('content')
<div class="container max-w-lg">
    <div class="bg-white rounded shadow p-8">
        {!! html()->modelForm($webhookSubscription, 'PUT', route('store.webhook_subscriptions.edit', $webhookSubscription))
            ->class('space-y-6')
            ->open() !!}

            @include('store.webhook_subscriptions._form')

            <div class="flex justify-end space-x-3">
                <a href="{{ route('store.webhook_subscriptions.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">Cancel</a>
                {!! html()->button('Update Subscription')
                    ->type('submit')
                    ->class('px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition') !!}
            </div>
        {!! html()->form()->close() !!}
    </div>

    <div class="mt-6 bg-white rounded shadow p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Signing Secret</h3>
        <p class="text-xs text-gray-500 mb-2">Use this secret to verify the HMAC-SHA256 signature on incoming webhook payloads.</p>
        <div class="flex items-center gap-2">
            <code class="flex-1 bg-gray-100 rounded px-3 py-2 text-sm font-mono text-gray-800 break-all">{{ $webhookSubscription->secret }}</code>
        </div>
    </div>
</div>
@endsection
