@php
    // Inisialisasi rute menu navigasi terpusat
    $navLinks = [
        // SINKRONISASI: Pastikan nama rute sesuai dengan penamaan ->name() di routes/web.php
        ['label' => 'Home',           'route' => 'homepage',       'icon' => 'home',         'page' => 'home'],
        ['label' => 'Accommodations', 'route' => 'accomodations.open', 'icon' => 'hotel',        'page' => 'hotel'],
        ['label' => 'Flights',       'route' => 'flights',        'icon' => 'flight',       'page' => 'flights'],
        ['label' => 'Deals',         'route' => 'deals',          'icon' => 'local_offer',  'page' => 'promo'],
        ['label' => 'My Bookings',   'route' => 'bookings',       'icon' => 'luggage',      'page' => 'bookings'],
    ];

    $currentPage = $currentPage ?? '';
@endphp

<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-white/30 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 md:px-16 flex justify-between items-center h-20">
        <a class="flex items-center gap-2 hover:opacity-80 transition-opacity" href="{{ route('homepage') }}">
            <span class="material-symbols-outlined text-blue-600 text-[32px] icon-fill">flight_takeoff</span>
            <span class="font-display text-2xl text-on-surface tracking-tight font-bold">Stay<span class="text-blue-600">Go</span></span>
        </a>

        <div class="hidden md:flex items-center gap-8 h-full">
            @foreach ($navLinks as $link)
                @php $targetUrl = Route::has($link['route']) ? route($link['route']) : '#'; @endphp
                
                <a href="{{ $targetUrl }}"
                   class="text-sm font-semibold transition-all duration-300 relative pb-1 h-fit
                   {{ $currentPage === $link['page'] 
                       ? 'text-blue-600 -translate-y-1 font-bold border-b-2 border-blue-600' 
                       : 'text-on-surface-variant hover:text-blue-900 hover:-translate-y-0.5' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            <a href="#" class="flex items-center gap-1.5 text-sm font-medium text-on-surface-variant hover:text-blue-600 transition-colors px-3 py-2 rounded-xl hover:bg-gray-100/50">
                <span class="material-symbols-outlined text-blue-600 text-[22px]">favorite</span>
                <span class="hidden lg:inline">Favourites</span>
            </a>

            <div class="flex items-center gap-3 pl-3 border-l border-gray-200">
                {{-- Tampilan Kondisional jika User sudah login --}}
                @auth
                    @php
                        $firstName = Auth::user()->first_name ?? '';
                        $lastName = Auth::user()->last_name ?? '';
                        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                    @endphp
                    
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-sm font-semibold text-gray-800 leading-tight">
                            {{ $firstName }} {{ $lastName }}
                        </span>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                        @csrf
                    </form>
                    
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                            title="Click to Sign Out"
                            class="relative w-10 h-10 rounded-full border-2 border-blue-100 overflow-hidden hover:border-red-500 transition-all duration-300 flex items-center justify-center bg-blue-600 text-white font-bold text-sm shadow-sm">
                        {{ $initials ?: 'U' }}
                    </button>
                @else
                    {{-- Tampilan jika User belum login (Guest) --}}
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-sm font-medium text-gray-500 leading-tight">Guest Traveler</span>
                    </div>
                    <a href="{{ route('login') }}" class="relative w-10 h-10 rounded-full border-2 border-gray-200 overflow-hidden hover:border-blue-600 transition-all duration-300 flex items-center justify-center bg-gray-50 text-gray-600 font-bold text-sm">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </a>
                @endauth
            </div>

            <button id="mobile-menu-btn" class="md:hidden text-on-surface p-2 focus:outline-none">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-xl border-t border-gray-100 px-6 py-4 flex flex-col gap-3">
        @foreach ($navLinks as $link)
            @php $targetUrl = Route::has($link['route']) ? route($link['route']) : '#'; @endphp
            <a href="{{ $targetUrl }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-on-surface hover:bg-gray-100 transition-colors">
                <span class="material-symbols-outlined text-[20px] text-blue-600">{{ $link['icon'] }}</span>
                {{ $link['label'] }}
            </a>
        @endforeach
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-on-surface hover:bg-gray-100 transition-colors">
            <span class="material-symbols-outlined text-[20px] text-blue-600">favorite</span>Favourites
        </a>
        @auth
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined text-[20px] text-red-600">logout</span>Sign Out
            </a>
        @else
            <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-on-surface hover:bg-gray-100 transition-colors">
                <span class="material-symbols-outlined text-[20px] text-blue-600">login</span>Sign In
            </a>
        @endauth
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function(){
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>