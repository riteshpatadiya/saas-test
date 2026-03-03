@extends('store.layouts.default')

@section('title', 'New Checkout')

@section('page-title', 'New Checkout')

@section('content')
<div class="container max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('store.checkouts.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Checkouts</a>
    </div>

    <div class="bg-white rounded shadow p-8">
        <p class="text-sm text-gray-500 mb-6">
            Select a fulfillment location and add one or more product variants. Stock will be reserved for
            <strong>10 minutes</strong> while you confirm the order.
        </p>

        {!! html()->form('POST', route('store.checkouts.new'))
            ->class('space-y-6')
            ->open() !!}

            @include('store.checkouts._form')

            <div class="flex justify-end space-x-3 pt-2">
                <a href="{{ route('store.checkouts.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    Cancel
                </a>
                {!! html()->button('Reserve Stock & Create Checkout')
                    ->type('submit')
                    ->class('px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition') !!}
            </div>

        {!! html()->form()->close() !!}
    </div>
</div>
@endsection
