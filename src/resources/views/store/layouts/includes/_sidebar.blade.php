<aside class="w-64 bg-white shadow-md hidden md:block">
    <div class="p-6 border-b">
        <span class="block text-xl font-bold">{{ app()->make('currentStore')->name }}</span>
        <span class="block text-xl font-bold text-gray-500">Store Panel</span>
    </div>
    <nav class="mt-6 px-4 space-y-2">
        <a href="{{ route('store.dashboard.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.dashboard.index')) bg-gray-100 font-semibold @endif">
            Dashboard
        </a>

        <a href="{{ route('store.store_locations.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.store_locations.*')) bg-gray-100 font-semibold @endif">
            Locations
        </a>

        <a href="{{ route('store.products.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.products.*')) bg-gray-100 font-semibold @endif">
            Products
        </a>

        <a href="{{ route('store.product-variants.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.product-variants.*')) bg-gray-100 font-semibold @endif">
            Product Variants
        </a>

       <a href="{{ route('store.inventories.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.inventories.*')) bg-gray-100 font-semibold @endif">
           Inventories
       </a>

       <a href="{{ route('store.checkouts.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.checkouts.*')) bg-gray-100 font-semibold @endif">
           Checkouts
       </a>

       <a href="{{ route('store.orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.orders.*')) bg-gray-100 font-semibold @endif">
           Orders
       </a>

       <a href="{{ route('store.webhook_subscriptions.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.webhook_subscriptions.*')) bg-gray-100 font-semibold @endif">
           Webhooks
       </a>

       <a href="{{ route('store.audit_logs.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('store.audit_logs.*')) bg-gray-100 font-semibold @endif">
           Audit Logs
       </a>
   </nav>
</aside>
