@if(session()->has('flash_notification'))
@foreach(session('flash_notification') as $flash)
<div data-flash-message class="relative mb-4 p-4 rounded-md border
                @if($flash['level'] === 'success') bg-green-100 text-green-800 border-green-200
                @elseif($flash['level'] === 'danger') bg-red-100 text-red-800 border-red-200
                @elseif($flash['level'] === 'warning') bg-yellow-100 text-yellow-800 border-yellow-200
                @else bg-blue-100 text-blue-800 border-blue-200
                @endif
            ">
    {{ $flash['message'] }}
    <button type="button" class="absolute top-2 right-2 text-2xl text-gray-400" aria-label="Close">&times;</button>
</div>

@endforeach
@endif
