<header x-data="headerComponent()" x-init="init()" class="relative z-50">

    <!-- Desktop Header -->
    <div :class="scrolled ? 'bg-gray-900/70 backdrop-blur-md shadow-lg border-b border-white/10' : 'bg-transparent'"
        class="hidden md:block fixed top-0 left-0 right-0 text-white transition-all duration-300 z-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-24 flex justify-between items-center">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-2xl font-bold">
                Nan<span class="text-purple-500">Flex</span>
            </a>

            <!-- Navigation -->
            <nav class="flex space-x-10 bg-gray-800/50 backdrop-blur-md rounded-full px-6 py-4">
                <a href="{{ url('/') }}" class="hover:text-purple-500 transition">{{ __('messages.home') }}</a>
                <a href="{{ url('/movies') }}" class="hover:text-purple-500 transition">{{ __('messages.movies') }}</a>
                <a href="{{ url('/theaters') }}"
                    class="hover:text-purple-500 transition">{{ __('messages.theaters') }}</a>
                <a href="{{ url('/releases') }}"
                    class="hover:text-purple-500 transition">{{ __('messages.releases') }}</a>
            </nav>

            <!-- Right -->
            <div class="flex items-center space-x-4">

                <!-- Language Switch -->
                <div class="relative">
                    <button @click="langOpen = !langOpen"
                        class="flex items-center space-x-2 hover:bg-gray-700 px-3 py-2 rounded-full transition">
                        <img :src="languages[locale].flag" class="w-5 h-5 rounded-full">
                        <span x-text="locale.toUpperCase()"></span>
                    </button>

                    <div x-show="langOpen" x-cloak @click.away="langOpen=false" x-transition
                        class="absolute right-0 mt-3 w-40 bg-gray-800 rounded-xl shadow-xl overflow-hidden">
                        <template x-for="(lang, key) in languages" :key="key">
                            <button @click="changeLang(key)"
                                class="flex items-center space-x-2 w-full px-4 py-2 hover:bg-gray-700">
                                <img :src="lang.flag" class="w-5 h-5 rounded-full">
                                <span x-text="lang.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Auth Links -->
                @guest
                    <a href="{{ url('/login') }}"
                        class="bg-purple-500 hover:bg-purple-600 px-5 py-2 rounded-full transition">
                        {{ __('messages.login') }}
                    </a>
                @endguest

                @auth
                    <div class="relative" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen"
                            class="flex items-center space-x-2 hover:bg-gray-700 px-3 py-2 rounded-full">
                            <div
                                class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </button>

                        <div x-show="userOpen" x-cloak @click.away="userOpen=false" x-transition
                            class="absolute right-0 mt-3 w-44 bg-gray-800 rounded-xl shadow-xl">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700">{{ __('messages.profile') }}</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700">{{ __('messages.myTickets') }}</a>

                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button
                                    class="w-full text-left px-4 py-2 hover:bg-red-500">{{ __('messages.logout') }}</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Logo -->
    <a href="{{ url('/') }}" class="text-2xl font-bold text-white lg:hidden fixed top-4 left-4 z-50">
        {{-- Nan<span class="text-purple-500">Flex</span> --}}
        <img src="{{ asset('assets/icons/N-logo.png') }}" alt="NanFlex Logo" class="w-full">

    </a>

    <!-- Mobile Language Switch (Top Right) -->
    <div class="lg:hidden fixed top-4 right-4 z-50">
        <div class="relative">
            <button @click="langOpen = !langOpen"
                class="flex items-center justify-center w-10 h-10 bg-gray-800/70 rounded-full shadow-md">
                <img :src="languages[locale].flag" class="w-5 h-5 rounded-full">
            </button>

            <div x-show="langOpen" x-cloak @click.away="langOpen=false" x-transition
                class="absolute right-0 mt-3 w-36 bg-gray-800 rounded-xl shadow-xl overflow-hidden">
                <template x-for="(lang, key) in languages" :key="key">
                    <button @click="changeLang(key)"
                        class="flex items-center space-x-2 w-full px-3 py-2 hover:bg-gray-700">
                        <img :src="lang.flag" class="w-5 h-5 rounded-full">
                        <span x-text="lang.label"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Mobile Logo -->
    <a href="{{ url('/') }}" class="text-2xl font-bold text-white lg:hidden fixed top-4 left-4 z-50">
        {{-- Nan<span class="text-purple-500">Flex</span> --}}
        <img src="{{ asset('assets/icons/N-logo.png') }}" alt="NanFlex Logo" class="w-full">
    </a>

    <!-- Mobile Language Switch (Top Right) -->
    <div class="lg:hidden fixed top-4 right-4 z-50">
        <div class="relative">
            <button @click="langOpen = !langOpen"
                class="flex items-center justify-center w-10 h-10 bg-gray-800/70 rounded-full shadow-md">
                <img :src="languages[locale].flag" class="w-5 h-5 rounded-full">
            </button>

            <!-- Language Dropdown -->
            <div x-show="langOpen" x-cloak @click.away="langOpen=false" x-transition
                class="absolute right-0 mt-3 w-36 bg-gray-800 rounded-xl shadow-xl overflow-hidden">
                <template x-for="(lang, key) in languages" :key="key">
                    <button @click="changeLang(key)"
                        class="flex items-center space-x-2 w-full px-3 py-2 hover:bg-gray-700">
                        <img :src="lang.flag" class="w-5 h-5 rounded-full">
                        <span x-text="lang.label"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <!-- Mobile Bottom Navigation -->
    <nav x-data="{ active: '{{ request()->path() }}' }"
        class="fixed bottom-0 left-0 right-0 md:hidden bg-gray-900/90 backdrop-blur-md flex justify-around items-center h-16 text-white z-40">

        <!-- Home -->
        <a href="{{ url('/') }}" @click="active='/'"
            :class="active === '/' ? 'text-purple-500' : 'text-white'"
            class="flex flex-col items-center justify-center text-xs transition">
            <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z" />
            </svg>
            <span>{{ __('messages.home') }}</span>
        </a>

        <!-- Movies -->
        <a href="{{ url('/movies') }}" @click="active='movies'"
            :class="active === 'movies' ? 'text-purple-500' : 'text-white'"
            class="flex flex-col items-center justify-center text-xs transition">
            <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m7-7v14" />
            </svg>
            <span>{{ __('messages.movies') }}</span>
        </a>

        <!-- Theaters -->
        <a href="{{ url('/theaters') }}" @click="active='theaters'"
            :class="active === 'theaters' ? 'text-purple-500' : 'text-white'"
            class="flex flex-col items-center justify-center text-xs transition">
            <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
            </svg>
            <span>{{ __('messages.theaters') }} </span>
        </a>

        <!-- Releases -->
        <a href="{{ url('/releases') }}" @click="active='releases'"
            :class="active === 'releases' ? 'text-purple-500' : 'text-white'"
            class="flex flex-col items-center justify-center text-xs transition">
            <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
            </svg>
            <span>{{ __('messages.releases') }} </span>
        </a>

        <!-- Auth -->
        @guest
            <a href="{{ url('/login') }}" @click="active='login'"
                :class="active === 'login' ? 'text-purple-500' : 'text-white'"
                class="flex flex-col items-center justify-center text-xs transition">
                <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A3 3 0 017 15h10a3 3 0 012.879 2.804M12 7v4m0 0v4m0-4h4m-4 0H8" />
                </svg>
                <span>{{ __('messages.login') }}</span>
            </a>
        @endguest

        @auth
            <a href="{{ url('/profile') }}" @click="active='profile'"
                :class="active === 'profile' ? 'text-purple-500' : 'text-white'"
                class="flex flex-col items-center justify-center text-xs transition">
                <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A9 9 0 1112 3a9 9 0 01-6.879 14.804z" />
                </svg>
                <span>{{ __('messages.profile') }}</span>
            </a>
        @endauth
    </nav>

</header>

<script>
    function headerComponent() {
        return {
            scrolled: false,
            langOpen: false,
            locale: '{{ session('locale', app()->getLocale()) }}',

            languages: {
                en: {
                    label: "English",
                    flag: "/assets/lang/en.png"
                },
                kh: {
                    label: "Khmer",
                    flag: "/assets/lang/kh.png"
                },
                kr: {
                    label: "Korean",
                    flag: "/assets/lang/kr.png"
                },
                jp: {
                    label: "Japanese",
                    flag: "/assets/lang/jp.png"
                }, // ✅ Added
            },

            init() {
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 50;
                });
            },

            changeLang(lang) {
                this.locale = lang;
                this.langOpen = false;

                fetch('/set-language', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        locale: lang
                    })
                }).then(() => window.location.reload());
            }
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    [x-cloak] {
        display: none;
    }
</style>
