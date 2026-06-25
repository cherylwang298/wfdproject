@php
    // Inisialisasi rute menu navigasi terpusat
    $navLinks = [
        ['label' => 'Home',           'route' => 'homepage',       'icon' => 'home',         'page' => 'home'],
        ['label' => 'Accommodations', 'route' => 'accommodations', 'icon' => 'hotel',        'page' => 'hotel'],
        ['label' => 'Flights',       'route' => 'flights',        'icon' => 'flight',       'page' => 'flights'],
        ['label' => 'Deals',         'route' => 'deals',          'icon' => 'local_offer',  'page' => 'promo'],
        ['label' => 'My Bookings',   'route' => 'bookings',       'icon' => 'luggage',      'page' => 'bookings'],
    ];

    // Mengambil nilai variabel $currentPage dari view yang memanggil, default kosong jika tidak diset
    $currentPage = $currentPage ?? '';
@endphp

<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-white/30 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 md:px-16 flex justify-between items-center h-20">
        <!-- Brand -->
        <a class="flex items-center gap-2 hover:opacity-80 transition-opacity" href="{{ route('homepage') }}">
            <span class="material-symbols-outlined text-primary-container text-[32px] icon-fill">flight_takeoff</span>
            <span class="font-display text-2xl text-on-surface tracking-tight font-bold">Stay<span class="text-primary-container">Go</span></span>
        </a>

        <!-- Desktop Nav -->
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

        <!-- Actions -->
        <div class="flex items-center gap-3">
            <a href="#" class="flex items-center gap-1.5 text-sm font-medium text-on-surface-variant hover:text-primary transition-colors px-3 py-2 rounded-xl hover:bg-surface-container/50">
                <span class="material-symbols-outlined text-primary-container text-[22px]">favorite</span>
                <span class="hidden lg:inline">Favourites</span>
            </a>

            <div class="flex items-center gap-3 pl-3 border-l border-outline-variant/30">
                {{-- Tampilan Kondisional jika User sudah login --}}
                @auth
                    @php
                        // Memecah nama user lokal untuk mengambil inisial
                        $firstName = Auth::user()->first_name ?? '';
                        $lastName = Auth::user()->last_name ?? '';
                        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                    @endphp
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-sm font-medium text-on-surface leading-tight">{{ $firstName }} {{ $lastName }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">@csrf</form>
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                            title="Click to Sign Out"
                            class="relative w-10 h-10 rounded-full border-2 border-primary/20 overflow-hidden hover:border-red-500 transition-all duration-300 flex items-center justify-center bg-primary-container text-on-primary font-bold text-sm">
                        {{ $initials ?: 'U' }}
                    </button>
                @else
                    {{-- Tampilan jika User belum login (Guest) --}}
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-sm font-medium text-on-surface leading-tight">Guest Traveler</span>
                    </div>
                    <a href="{{ route('login.form') }}" class="relative w-10 h-10 rounded-full border-2 border-primary/20 overflow-hidden hover:border-primary transition-all duration-300 flex items-center justify-center bg-gray-100 text-on-surface-variant font-bold text-sm">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <button id="mobile-menu-btn" class="md:hidden text-on-surface p-2 focus:outline-none">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-xl border-t border-outline-variant/20 px-6 py-4 flex flex-col gap-3">
        @foreach ($navLinks as $link)
            @php $targetUrl = Route::has($link['route']) ? route($link['route']) : '#'; @endphp
            <a href="{{ $targetUrl }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-on-surface hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[20px] text-primary">{{ $link['icon'] }}</span>
                {{ $link['label'] }}
            </a>
        @endforeach
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-on-surface hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[20px] text-primary">favorite</span>Favourites
        </a>
        @auth
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined text-[20px] text-red-600">logout</span>Sign Out
            </a>
        @else
            <a href="{{ route('login.form') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-on-surface hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[20px] text-primary">login</span>Sign In
            </a>
        @endauth
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function(){
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>