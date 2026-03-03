@extends('store.layouts.default')

@section('title', 'Orders')

@section('page-title', 'Orders')

@section('content')
<div class="container mx-auto">

    {{-- Status filter --}}
    <div class="flex items-center gap-3 mb-4">
        <form method="GET" action="{{ route('store.orders.index') }}" class="flex items-center gap-3">
            <select name="status"
                class="px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-blue-500">
                <option value="">All statuses</option>
                <option value="CREATED" @selected($status === 'CREATED')>CREATED</option>
                <option value="PAID"    @selected($status === 'PAID')>PAID</option>
            </select>
            <button type="submit" class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 text-sm">
                Filter
            </button>
            @if($status)
                <a href="{{ route('store.orders.index') }}" class="text-sm text-gray-500 hover:underline">Clear</a>
            @endif
        </form>

        <div class="ml-auto">
            <a href="{{ route('store.checkouts.new') }}"
               class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                + New Checkout
            </a>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paid At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-semibold text-gray-900">
                            {{ $order->number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($order->status === 'PAID')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">PAID</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">CREATED</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-700">
                            ${{ number_format($order->subtotal, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            ${{ number_format($order->total, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $order->paid_at?->format('d/m/Y H:i') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $order->created_at?->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('store.orders.show', ['order' => $order->id]) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
