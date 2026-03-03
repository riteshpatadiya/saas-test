 <!-- Sidebar -->
 <aside class="w-64 bg-white shadow-md hidden md:block">
     <div class="p-6 border-b">
         <span class="text-xl font-bold">SaaS Admin Panel</span>
     </div>
    <nav class="mt-6 px-4 space-y-2">
        <a href="{{ route('admin.dashboard.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('admin.dashboard.*')) bg-gray-100 font-semibold @endif">
        Dashboard
        </a>

        <a href="{{ route('admin.stores.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('admin.stores.*')) bg-gray-100 font-semibold @endif">
        Stores
        </a>

        <a href="{{ route('admin.store-locations.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('admin.store-locations.*')) bg-gray-100 font-semibold @endif">
        Store Locations
        </a>

        <a href="{{ route('admin.store-users.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('admin.store-users.*')) bg-gray-100 font-semibold @endif">
        Store Users
        </a>

        <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('admin.products.*')) bg-gray-100 font-semibold @endif">
        Products
        </a>

        <a href="{{ route('admin.product-variants.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('admin.product-variants.*')) bg-gray-100 font-semibold @endif">
        Product Variants
        </a>

        <a href="{{ route('admin.inventories.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 @if (request()->routeIs('admin.inventories.*')) bg-gray-100 font-semibold @endif">
        Inventory
        </a>
    </nav>
 </aside>
