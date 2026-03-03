@extends('admin.layouts.default')

@section('title', 'Add Store')

@section('page-title', 'Add Store')

@section('content')
<div class="container max-w-lg">
    <div class="bg-white rounded shadow p-8">
        {!! html()->form('POST', route('admin.stores.new'))
            ->class('space-y-6')
            ->open() !!}
        
            @include('admin.stores._form')
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.stores.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">Cancel</a>
                {!! html()->button('Create Store')
                    ->type('submit')
                    ->class('px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition') !!}
            </div>
        {!! html()->form()->close() !!}
    </div>
</div>
@endsection 