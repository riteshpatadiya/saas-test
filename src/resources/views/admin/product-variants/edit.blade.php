@extends('admin.layouts.default')

@section('title', 'Edit Product Variant')

@section('page-title', 'Edit Product Variant')

@section('content')
<div class="container max-w-lg">
    <div class="bg-white rounded shadow p-8">
        {!! html()->modelForm($variant, 'PUT', route('admin.product-variants.edit', $variant))
            ->class('space-y-6')
            ->open() !!}

            @include('admin.product-variants._form')

            <div class="flex justify-between items-center">
                <div class="flex space-x-3">
                    <a href="{{ route('admin.product-variants.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">Cancel</a>
                    {!! html()->button('Update Product Variant')
                        ->type('submit')
                        ->class('px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition') !!}
                </div>
            </div>
        {!! html()->form()->close() !!}
    </div>
</div>
@endsection

