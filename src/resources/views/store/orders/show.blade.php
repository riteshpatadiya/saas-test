@extends('store.layouts.default')

@section('title', 'Order ' . $order->number)

@section('page-title', 'Order Detail')

@section('content')
<div class="container max-w-2xl space-y-6">

    <div>
        <a href="{{ route('store.orders.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Orders</a>
    </div>

    {{-- Order Header --}}
    <div class="bg-white rounded shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Order Number</p>
                <p class="text-2xl font-mono font-bold text-gray-900">{{ $order->number }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Placed {{ $order->created_at?->format('d M Y, H:i') }}
                </p>
            </div>

            <div class="text-right space-y-1">
                @if($order->status === 'PAID')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                        PAID
                    </span>
                    <p class="text-xs text-gray-500">{{ $order->paid_at?->format('d M Y, H:i') }}</p>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                        CREATED
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Status Timeline --}}
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Status History</h2>
        <ol class="relative border-l border-gray-200 ml-3 space-y-4">
            <li class="ml-4">
                <div class="absolute -left-1.5 mt-1.5 w-3 h-3 rounded-full border-2 border-white bg-green-500"></div>
                <p class="text-sm font-semibold text-gray-800">CREATED</p>
                <p class="text-xs text-gray-500">{{ $order->created_at?->format('d M Y, H:i:s') }}</p>
            </li>
            @if($order->status === 'PAID')
                <li class="ml-4">
                    <div class="absolute -left-1.5 mt-1.5 w-3 h-3 rounded-full border-2 border-white bg-green-600"></div>
                    <p class="text-sm font-semibold text-gray-800">PAID</p>
                    <p class="text-xs text-gray-500">{{ $order->paid_at?->format('d M Y, H:i:s') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Payment simulated successfully</p>
                </li>
            @endif
        </ol>
    </div>

    {{-- Line Items --}}
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Line Items</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Variant</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Line Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($order->items as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm font-mono text-gray-800">{{ $item->sku }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $item->product_name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $item->variant_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-right text-gray-800">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-right text-gray-800">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium text-gray-900">${{ number_format($item->line_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">No items.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Totals Summary --}}
        <div class="mt-4 border-t pt-4 space-y-1.5 text-sm">
            <div class="flex justify-end gap-8 text-gray-600">
                <span>Subtotal</span>
                <span class="w-28 text-right">${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-end gap-8 text-gray-600">
                <span>Tax</span>
                <span class="w-28 text-right">${{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="flex justify-end gap-8 text-gray-600">
                <span>Discount</span>
                <span class="w-28 text-right">-${{ number_format($order->discount, 2) }}</span>
            </div>
            <div class="flex justify-end gap-8 font-bold text-gray-900 text-base border-t pt-2">
                <span>Total</span>
                <span class="w-28 text-right">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
