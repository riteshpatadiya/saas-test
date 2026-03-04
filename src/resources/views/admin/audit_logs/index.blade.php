@extends('admin.layouts.default')

@section('title', 'Audit Logs')

@section('page-title', 'Audit Logs')

@section('content')
<div class="container mx-auto">

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.audit_logs.index') }}" class="bg-white rounded shadow p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[180px]">
                <label for="store_id" class="block text-xs font-medium text-gray-600 mb-1 uppercase tracking-wide">Store</label>
                <select id="store_id" name="store_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Stores</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" @selected(request('store_id') == $store->id)>{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[180px]">
                <label for="action" class="block text-xs font-medium text-gray-600 mb-1 uppercase tracking-wide">Action</label>
                <select id="action" name="action" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Actions</option>
                    @foreach($actions as $value => $label)
                        <option value="{{ $value }}" @selected(request('action') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="min-w-[160px]">
                <label for="date_from" class="block text-xs font-medium text-gray-600 mb-1 uppercase tracking-wide">Date From</label>
                <input
                    type="date"
                    id="date_from"
                    name="date_from"
                    value="{{ request('date_from') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="min-w-[160px]">
                <label for="date_to" class="block text-xs font-medium text-gray-600 mb-1 uppercase tracking-wide">Date To</label>
                <input
                    type="date"
                    id="date_to"
                    name="date_to"
                    value="{{ request('date_to') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                    Filter
                </button>
                @if(request()->hasAny(['store_id', 'action', 'date_from', 'date_to']))
                    <a href="{{ route('admin.audit_logs.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded hover:bg-gray-200 transition">
                        Clear
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Results --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date / Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metadata</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $log->store?->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                $badgeColors = [
                                    'product.created'              => 'bg-green-100 text-green-800',
                                    'product.updated'              => 'bg-blue-100 text-blue-800',
                                    'inventory.adjusted'           => 'bg-yellow-100 text-yellow-800',
                                    'checkout.completed'           => 'bg-purple-100 text-purple-800',
                                    'webhook_subscription.created' => 'bg-teal-100 text-teal-800',
                                    'webhook_subscription.updated' => 'bg-cyan-100 text-cyan-800',
                                    'webhook_subscription.deleted' => 'bg-red-100 text-red-800',
                                ];
                                $color = $badgeColors[$log->action] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                {{ $log->action_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="font-medium">{{ $log->entity_type }}</span>
                            @if($log->entity_id)
                                <span class="text-gray-400">#{{ $log->entity_id }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($log->actor_id)
                                #{{ $log->actor_id }}
                                <span class="text-gray-400 text-xs">({{ $log->actor_type }})</span>
                            @else
                                <span class="text-gray-400 italic">system</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                            @if($log->metadata)
                                <details class="cursor-pointer">
                                    <summary class="text-blue-600 hover:underline text-xs">View details</summary>
                                    <pre class="mt-2 p-2 bg-gray-50 rounded text-xs overflow-auto max-h-32 whitespace-pre-wrap">{{ json_encode($log->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                </details>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                            No audit log entries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>

</div>
@endsection
