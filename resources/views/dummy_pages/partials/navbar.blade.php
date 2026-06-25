<nav class="bg-white border-b">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <div class="font-extrabold text-xl">
            Stay<span class="text-blue-600">Go</span>
        </div>

        <!-- MENU -->
        <div class="hidden md:flex gap-6 text-sm font-medium text-slate-600">
            <a href="#" class="hover:text-blue-600">Home</a>
            <a href="#" class="hover:text-blue-600">Accomodation</a>
            <a href="#" class="hover:text-blue-600">Flights</a>
            <a href="#" class="hover:text-blue-600">Deals</a>
            <a href="#" class="hover:text-blue-600">My Bookings</a>
        </div>

        <!-- AUTH -->
        <div class="flex gap-3">

            {{-- {{ Auth::check() ? 'LOGIN' : 'GUEST' }} --}}

    @auth

        <span class="text-sm px-4 py-2">
            Hi, {{ Auth::user()->first_name }}
        </span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="text-sm px-4 py-2 rounded-full border hover:bg-slate-50"
            >
                Logout
            </button>
        </form>

    @else

        <a
            href="{{ route('login.form') }}"
            class="text-sm px-4 py-2 rounded-full border hover:bg-slate-50"
        >
            Login
        </a>

        <a
            href="{{ route('register.form') }}"
            class="text-sm px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700"
        >
            Sign Up
        </a>

    @endauth

</div>

    </div>
</nav>