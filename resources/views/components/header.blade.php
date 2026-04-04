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


    <!-- Mobile Bottom Navigation -->
    {{-- Top-left hamburger button (mobile only) --}}
    <div x-data="{
        open: false,
        active: '{{ request()->path() }}'
    }" class="md:hidden">

        {{-- Hamburger Button --}}
        <button @click="open = true"
            class="fixed top-4 left-4 z-50 flex items-center justify-center w-10 h-10 rounded-full bg-black backdrop-blur-md text-white shadow-lg">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Backdrop Overlay --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" style="display: none;">
        </div>

        {{-- Left Sidebar --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed top-0 left-0 h-full w-72 bg-gray-800/50 z-50 flex flex-col shadow-2xl" style="display: none;">

            {{-- Sidebar Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-700/50">
                <span class="text-white font-semibold text-lg tracking-wide">🎬 CineBook</span>
                <button @click="open = false" class="text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Nav Links --}}
            <nav class="flex flex-col gap-1 px-3 py-4 flex-1 overflow-y-auto">

                {{-- Home --}}
                <a href="{{ url('/') }}" @click="active = '/'; open = false"
                    :class="active === '/' ? 'bg-purple-600/20 text-purple-400' :
                        'text-gray-300 hover:bg-gray-800 hover:text-white'"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z" />
                    </svg>
                    <span x-text="translations.home"></span>
                    <span x-show="active === '/'" class="ml-auto w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                </a>

                {{-- Movies --}}
                <a href="{{ url('/movies') }}" @click="active = 'movies'; open = false"
                    :class="active === 'movies' ? 'bg-purple-600/20 text-purple-400' :
                        'text-gray-300 hover:bg-gray-800 hover:text-white'"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                    <span x-text="translations.movies"></span>
                    <span x-show="active === 'movies'" class="ml-auto w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                </a>

                {{-- Theaters --}}
                <a href="{{ url('/theaters') }}" @click="active = 'theaters'; open = false"
                    :class="active === 'theaters' ? 'bg-purple-600/20 text-purple-400' :
                        'text-gray-300 hover:bg-gray-800 hover:text-white'"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <span x-text="translations.theaters"></span>
                    <span x-show="active === 'theaters'"
                        class="ml-auto w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                </a>

                {{-- Releases --}}
                <a href="{{ url('/releases') }}" @click="active = 'releases'; open = false"
                    :class="active === 'releases' ? 'bg-purple-600/20 text-purple-400' :
                        'text-gray-300 hover:bg-gray-800 hover:text-white'"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span x-text="translations.releases"></span>
                    <span x-show="active === 'releases'"
                        class="ml-auto w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                </a>

            </nav>

            {{-- Bottom Auth Section --}}
            <div class="px-3 py-4 border-t border-gray-700/50">
                @guest
                    <a href="{{ url('/login') }}" @click="open = false"
                        class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200">
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span x-text="translations.login"></span>
                    </a>
                @endguest

                @auth
                    <a href="{{ url('/profile') }}" @click="open = false"
                        class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200">
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1112 3a9 9 0 01-6.879 14.804z" />
                        </svg>
                        <span x-text="translations.profile"></span>
                    </a>
                @endauth
            </div>

        </div>
    </div>

</header>

<script>
    function headerComponent() {
        return {
            scrolled: false,
            langOpen: false,
            open: false,
            locale: '{{ session('locale', app()->getLocale()) }}',
            translations: @json(__('messages')),

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
                },
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
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.translations) {
                            this.translations = data.translations;
                        }
                    });
            }
        }
    }
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    [x-cloak] {
        display: none;
    }
</style>
