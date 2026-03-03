@extends('admin.layouts.default')

@section('title', 'Edit Store Location')

@section('page-title', 'Edit Store Location')

@section('content')
<div class="container max-w-lg">
    <div class="bg-white rounded shadow p-8">
        {!! html()->modelForm($storeLocation, 'PUT', route('admin.store-locations.edit', $storeLocation))
            ->class('space-y-6')
            ->open() !!}

            @include('admin.store-locations._form')

            <div class="flex justify-between items-center">
                <div class="flex space-x-3">
                    <a href="{{ route('admin.store-locations.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">Cancel</a>
                    {!! html()->button('Update Store Location')
                        ->type('submit')
                        ->class('px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition') !!}
                </div>
            </div>
        {!! html()->form()->close() !!}
    </div>
</div>
@endsection

