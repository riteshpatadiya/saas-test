@extends('store.layouts.default')

@section('title', 'Checkout ' . $checkout->token)

@section('page-title', 'Checkout')

@section('content')
<div class="container max-w-2xl space-y-6">

    <div>
        <a href="{{ route('store.checkouts.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Checkouts</a>
    </div>

    {{-- Token & Status Banner --}}
    <div class="bg-white rounded shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Checkout Token</p>
                <p class="text-2xl font-mono font-bold tracking-widest text-gray-900">{{ $checkout->token }}</p>
            </div>

            <div class="text-right">
                @if($checkout->status === 'OPEN')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                        OPEN
                    </span>
                    <p class="text-xs text-gray-500 mt-1">
                        Expires {{ $checkout->expires_at?->diffForHumans() }}
                        ({{ $checkout->expires_at?->format('H:i:s') }})
                    </p>
                @elseif($checkout->status === 'COMPLETED')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                        COMPLETED
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-600">
                        EXPIRED
                    </span>
                @endif
            </div>
        </div>

        <div class="mt-4 text-sm text-gray-600">
            <span class="font-medium">Location:</span>
            {{ optional($checkout->storeLocation)->name ?? '—' }}
        </div>
    </div>

    {{-- Expired notice --}}
    @if($checkout->status === 'EXPIRED')
        <div class="bg-yellow-50 border border-yellow-200 rounded p-4 text-sm text-yellow-800">
            This checkout token has expired and the reserved stock has been released.
            <a href="{{ route('store.checkouts.new') }}" class="font-semibold underline ml-1">Create a new checkout</a>.
        </div>
    @endif

    {{-- Completed notice --}}
    @if($checkout->status === 'COMPLETED' && $checkout->order_id)
        <div class="bg-blue-50 border border-blue-200 rounded p-4 text-sm text-blue-800">
            This checkout was completed.
            <a href="{{ route('store.orders.show', ['order' => $checkout->order_id]) }}" class="font-semibold underline ml-1">
                View Order
            </a>.
        </div>
    @endif

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
                    @forelse($checkout->items as $item)
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

        {{-- Totals --}}
        <div class="mt-4 border-t pt-4 space-y-1 text-sm text-right">
            <div class="flex justify-end gap-8 text-gray-600">
                <span>Subtotal</span>
                <span class="w-24 text-right">${{ number_format($checkout->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-end gap-8 text-gray-600">
                <span>Tax</span>
                <span class="w-24 text-right">${{ number_format($checkout->tax, 2) }}</span>
            </div>
            <div class="flex justify-end gap-8 font-bold text-gray-900 text-base border-t pt-2">
                <span>Total</span>
                <span class="w-24 text-right">${{ number_format($checkout->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Complete Order Action --}}
    @if($checkout->status === 'OPEN')
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Complete Order</h2>
            <p class="text-sm text-gray-500 mb-4">
                Clicking the button below will place the order and simulate a successful payment.
                Stock reserved for this checkout will be permanently deducted from inventory.
            </p>
            <form method="POST"
                  action="{{ route('store.checkouts.complete', ['checkout' => $checkout->id]) }}"
                  onsubmit="return confirm('Confirm order placement? This action cannot be undone.')">
                @csrf
                <button type="submit"
                    class="px-6 py-2.5 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                    Complete Order &amp; Simulate Payment
                </button>
            </form>
        </div>
    @endif

</div>
@endsection
