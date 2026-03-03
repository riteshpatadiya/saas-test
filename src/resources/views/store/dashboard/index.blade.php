@extends('store.layouts.default')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <h1>Welcome, {{ auth()->user()?->name }}</h1>
</div>
@endsection
