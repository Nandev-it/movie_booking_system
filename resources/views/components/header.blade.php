<header x-data="{ mobileMenu: false }" class="relative z-50">
    <!-- Top Header for Large Screens -->
    <div class="hidden md:block text-white ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-24 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-white">
                Nan<span class="text-purple-500">Flex</span>
            </a>

            <!-- Navigation -->
            <nav class="flex space-x-10 bg-gray-800/50 backdrop-blur-md rounded-full px-6 py-4">
                <a href="{{ url('/') }}"
                    class="transition hover:text-purple-500 {{ request()->is('/') ? 'text-purple-500' : 'text-white' }}">
                    Home
                </a>

                <a href="{{ url('/movies') }}"
                    class="transition hover:text-purple-500 {{ request()->is('movies') ? 'text-purple-500' : 'text-white' }}">
                    Movies
                </a>

                <a href="{{ url('/theaters') }}"
                    class="transition hover:text-purple-500 {{ request()->is('theaters') ? 'text-purple-500' : 'text-white' }}">
                    Theaters
                </a>

                <a href="{{ url('/releases') }}"
                    class="transition hover:text-purple-500 {{ request()->is('releases') ? 'text-purple-500' : 'text-white' }}">
                    Releases
                </a>
            </nav>

            <!-- Auth / Profile -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ url('/login') }}"
                        class="bg-purple-500 hover:bg-purple-600 px-4 py-2 rounded-full transition text-sm md:text-base">
                        Login
                    </a>
                @endguest

                @auth
                    <div x-data="{ userMenu: false }" class="relative">
                        <button @click="userMenu = !userMenu"
                            class="flex items-center space-x-2 hover:bg-gray-700 px-3 py-2 rounded-full transition">
                            <div
                                class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </button>

                        <div x-show="userMenu" x-cloak @click.away="userMenu=false" x-transition
                            class="absolute right-0 mt-3 w-40 bg-gray-800 rounded-lg shadow-lg overflow-hidden z-50">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700">Profile</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700">My Tickets</a>
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button class="w-full text-left px-4 py-2 hover:bg-red-500">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <!-- Mobile Bottom Navigation with active state -->
    <nav x-data="{ active: '{{ request()->path() }}' }"
        class="fixed bottom-0 left-0 right-0 md:hidden bg-gray-900/90 backdrop-blur-md flex justify-around items-center h-16 text-white z-50 border-t border-gray-800">

        <a href="{{ url('/') }}" :class="active === '/' ? 'text-purple-500' : 'text-white'"
            @click="active='/'" class="flex flex-col items-center justify-center transition text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z" />
            </svg>
            Home
        </a>

        <a href="#" :class="active === 'movies' ? 'text-purple-500' : 'text-white'" @click="active='movies'"
            class="flex flex-col items-center justify-center transition text-xs">
            <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m7-7v14" />
            </svg>
            Movies
        </a>

        <a href="#" :class="active === 'theaters' ? 'text-purple-500' : 'text-white'" @click="active='theaters'"
            class="flex flex-col items-center justify-center transition text-xs">
            <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
            </svg>
            Theaters
        </a>

        <a href="#" :class="active === 'releases' ? 'text-purple-500' : 'text-white'" @click="active='releases'"
            class="flex flex-col items-center justify-center transition text-xs">
            <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
            </svg>
            Releases
        </a>

        @guest
            <a href="{{ url('/login') }}" :class="active === 'login' ? 'text-purple-500' : 'text-white'"
                @click="active='login'" class="flex flex-col items-center justify-center transition text-xs">
                <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A3 3 0 017 15h10a3 3 0 012.879 2.804M12 7v4m0 0v4m0-4h4m-4 0H8" />
                </svg>
                Login
            </a>
        @endguest

        @auth
            <a href="{{ url('/profile') }}" :class="active === 'profile' ? 'text-purple-500' : 'text-white'"
                @click="active='profile'" class="flex flex-col items-center justify-center transition text-xs">
                <svg class="h-5 w-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A9 9 0 1112 3a9 9 0 01-6.879 14.804z" />
                </svg>
                Profile
            </a>
        @endauth
    </nav>
</header>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
    [x-cloak] {
        display: none;
    }
</style>
