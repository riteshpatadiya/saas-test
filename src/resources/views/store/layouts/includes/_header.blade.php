<header class="bg-white shadow px-4 py-4 flex items-center justify-between">
    <div class="flex items-center">
        <button class="md:hidden mr-4 focus:outline-none" id="openSidebar">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold">@yield('page-title', 'SaaS Store Panel')</h1>
    </div>
    <div>
        {{-- Add user/account actions here --}}
        <span class="text-sm text-gray-600">{{ Auth::user()->name ?? 'Administrator' }}</span> |
        <a href="{{ route('store.auth.logout')}}" class="text-sm text-red-700" title="Logout">Logout</a>
    </div>
</header>
