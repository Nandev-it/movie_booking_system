<header x-data="headerComponent()" x-init="init()" class="relative z-50">

    <!-- Desktop Header -->
    <div :class="scrolled ? 'bg-[#0d0f14]/95 shadow-lg' : 'bg-transparent'"
        class="hidden md:block fixed top-0 left-0 right-0 text-white transition-all duration-300 z-50 border-b border-white/[0.06]">

        <div class="max-w-7xl mx-auto px-8 h-[68px] flex items-center gap-8">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
                <img src="{{ asset('assets/logo/cineverse.png') }}" alt="Logo" class="w-32">
            </a>

            <!-- Nav Links -->
            <nav class="flex items-center gap-1 ml-2">
                <a href="{{ url('/') }}"
                    class="text-white text-sm font-medium px-3.5 py-1.5 rounded-md hover:bg-white/[0.07] transition-colors duration-200"
                    x-text="translations.home"></a>
                <a href="{{ url('/movies') }}"
                    class="text-white/70 text-sm font-medium px-3.5 py-1.5 rounded-md hover:bg-white/[0.07] hover:text-white transition-colors duration-200"
                    x-text="translations.movies"></a>
                <a href="{{ url('/theaters') }}"
                    class="text-white/70 text-sm font-medium px-3.5 py-1.5 rounded-md hover:bg-white/[0.07] hover:text-white transition-colors duration-200"
                    x-text="translations.theaters"></a>
                <a href="{{ url('/releases') }}"
                    class="text-white/70 text-sm font-medium px-3.5 py-1.5 rounded-md hover:bg-white/[0.07] hover:text-white transition-colors duration-200"
                    x-text="translations.releases"></a>
            </nav>

            <!-- Spacer -->
            <div class="flex-1"></div>

            <!-- Search -->
            <div class="relative flex items-center" x-data="{
                query: '',
                results: [],
                searching: false,
                showResults: false,
                async search() {
                    if (this.query.trim().length < 2) {
                        this.results = [];
                        this.showResults = false;
                        return;
                    }
                    this.searching = true;
                    this.showResults = true;
                    try {
                        const res = await fetch(`/search?q=${encodeURIComponent(this.query)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        this.results = await res.json();
                    } catch (e) { this.results = []; }
                    this.searching = false;
                },
                clear() {
                    this.query = '';
                    this.results = [];
                    this.showResults = false;
                }
            }">
                <div class="relative w-56">
                    <input type="text"
                        x-model="query"
                        @input.debounce.300ms="search()"
                        @focus="if(results.length) showResults = true"
                        @click.away="showResults = false"
                        :placeholder="translations.search ?? 'Search movies, shows…'"
                        class="w-full bg-white/[0.07] border border-white/10 rounded-lg text-white text-[13.5px]
                           placeholder-white/35 px-3.5 py-[7px] pr-9 outline-none
                           focus:border-white/25 focus:bg-white/10 transition-all duration-200" />
                    <span class="absolute right-3 top-2 text-white/40 pointer-events-none" x-show="!searching && query.length === 0">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 3a6 6 0 100 12A6 6 0 009 3zM1 9a8 8 0 1114.32 4.906l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387A8 8 0 011 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <svg x-show="searching" class="animate-spin absolute right-3 top-2" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 11-6.219-8.56" />
                    </svg>
                    <button x-show="query.length > 0 && !searching" @click="clear()" class="absolute right-3 top-2 text-white/40 hover:text-white/60">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Results Dropdown -->
                    <div x-show="showResults && results.length > 0" x-transition @click.away="showResults = false"
                        class="absolute left-0 right-0 top-full mt-2 rounded-xl overflow-hidden shadow-2xl z-50 bg-[#1e2130] border border-white/[0.08]"
                        style="min-width: 400px; max-height: 450px; overflow-y: auto;">
                        <div class="p-3">
                            <p class="text-xs mb-2 px-1 text-white/50">Results for "<span x-text="query" class="text-white/70"></span>"</p>
                            <div class="flex flex-col gap-2">
                                <template x-for="movie in results" :key="movie.id">
                                    <a :href="movie.url" @click="clear()"
                                        class="flex items-center gap-3 rounded-lg p-2 transition-colors duration-150 hover:bg-white/[0.05]">
                                        <img :src="movie.poster ?? '/assets/default-poster.jpg'" :alt="movie.title"
                                            class="w-12 h-16 object-cover rounded-md flex-shrink-0" style="min-width:48px;"
                                            onerror="this.src='/assets/default-poster.jpg'">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-white truncate" x-text="movie.title"></p>
                                            <p class="text-xs text-white/60 mt-0.5" x-text="movie.genre ?? ''"></p>
                                            <p class="text-xs text-white/40 mt-0.5"
                                                x-text="movie.duration ? Math.floor(movie.duration/60)+'h '+(movie.duration%60)+'m' : ''"></p>
                                            <div class="flex mt-1 text-yellow-400 text-xs">★ ★ ★ ★ ☆</div>
                                        </div>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" class="flex-shrink-0 text-white/40">
                                            <path d="M9 18l6-6-6-6" />
                                        </svg>
                                    </a>
                                </template>
                            </div>
                            <a :href="`/movies?search=${query}`" @click="clear()"
                                class="flex items-center justify-center gap-2 mt-3 py-2 rounded-lg text-xs transition-colors duration-150 border border-white/10 text-white/50 hover:text-white/75 hover:border-white/20">
                                View all results
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- No Results Message -->
                    <div x-show="showResults && !searching && results.length === 0 && query.length >= 2" x-transition
                        class="absolute left-0 right-0 top-full mt-2 rounded-lg px-4 py-4 text-sm text-center shadow-xl bg-[#1e2130] border border-white/[0.08] text-white/60"
                        style="min-width: 400px;">
                        No movies found for "<span x-text="query" class="text-white/80"></span>"
                    </div>
                </div>
            </div>

            <!-- Right -->
            <div class="flex items-center gap-1.5 shrink-0">

                <!-- Language Switch -->
                <div class="relative">
                    <button @click="langOpen = !langOpen"
                        class="flex items-center gap-1.5 text-white/75 text-[13.5px] font-medium
                           px-3 py-1.5 rounded-lg hover:bg-white/[0.07] hover:text-white transition-colors duration-200">
                        <img :src="languages[locale].flag" class="w-[18px] h-[18px] rounded-full object-cover">
                        <span x-text="locale.toUpperCase()"></span>
                    </button>

                    <div x-show="langOpen" x-cloak @click.away="langOpen=false" x-transition
                        class="absolute right-0 mt-2 w-40 bg-[#1e2130] border border-white/[0.08] rounded-xl shadow-2xl overflow-hidden">
                        <template x-for="(lang, key) in languages" :key="key">
                            <button @click="changeLang(key)"
                                class="flex items-center gap-2.5 w-full px-4 py-2.5 text-sm text-white/75 hover:bg-white/[0.07] hover:text-white transition-colors duration-200">
                                <img :src="lang.flag" class="w-[18px] h-[18px] rounded-full object-cover">
                                <span x-text="lang.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Divider -->
                <div class="w-px h-[22px] bg-white/10 mx-1"></div>

                <!-- Notification Bell -->
                <button
                    class="relative w-[38px] h-[38px] flex items-center justify-center rounded-lg
                           text-white/70 hover:bg-white/[0.07] hover:text-white transition-colors duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span
                        class="absolute top-[7px] right-[7px] w-2 h-2 rounded-full bg-[#4f8ef7] border-2 border-[#13151c]"></span>
                </button>

                @guest
                    <a href="{{ url('/login') }}"
                        class="bg-[#5b5fc7] hover:bg-[#6e72e0] text-white text-[13.5px] font-semibold
                           px-5 py-[7px] rounded-lg transition-colors duration-200"
                        x-text="translations.login"></a>
                @endguest

                @auth
                    <div class="relative" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen"
                            class="flex items-center gap-2 px-1 pr-3 py-1 rounded-lg
                               hover:bg-white/[0.07] transition-colors duration-200">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-[#6c63ff] to-[#4f8ef7]
                                    flex items-center justify-center text-white text-sm font-bold shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-[13.5px] font-medium text-white/85 whitespace-nowrap">
                                {{ Auth::user()->name }}
                            </span>
                        </button>

                        <div x-show="userOpen" x-cloak @click.away="userOpen=false" x-transition
                            class="absolute right-0 mt-2 w-44 bg-[#1e2130] border border-white/[0.08] rounded-xl shadow-2xl overflow-hidden">
                            <a href="{{ url('/profile') }}"
                                class="block px-4 py-2.5 text-sm text-white/75 hover:bg-white/[0.07] hover:text-white transition-colors duration-200"
                                x-text="translations.profile"></a>
                            <a href="{{ url('/my-tickets') }}"
                                class="block px-4 py-2.5 text-sm text-white/75 hover:bg-white/[0.07] hover:text-white transition-colors duration-200"
                                x-text="translations.myTickets"></a>
                            <div class="border-t border-white/[0.06]"></div>
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button
                                    class="w-full text-left px-4 py-2.5 text-sm text-white/75 hover:bg-red-500/80 hover:text-white transition-colors duration-200"
                                    x-text="translations.logout"></button>
                            </form>
                        </div>
                    </div>
                @endauth

            </div>
        </div>
    </div>

    <!-- Mobile Language Switch -->
    <div class="md:hidden fixed top-4 right-4 z-50">
        <div class="relative flex flex-col items-center">

            <!-- Language Button -->
            <button @click="langOpen = !langOpen"
                class="flex items-center justify-center w-10 h-10 rounded-full shadow-md cursor-pointer"
                style="background:#2a2a2e;">
                <img :src="languages[locale].flag" class="w-5 h-5 rounded-full">
            </button>

            <!-- Dropdown -->
            <div x-show="langOpen" x-cloak @click.away="langOpen=false" x-transition
                class="absolute right-0 mt-3 w-36 rounded-xl shadow-xl overflow-hidden cursor-pointer"
                style="background:#1c1c1e; border: 0.5px solid #2e2e32;">

                <template x-for="(lang, key) in languages" :key="key">
                    <button @click="changeLang(key)"
                        class="flex items-center gap-2 w-full px-3 py-2.5 text-sm transition-colors duration-150"
                        style="color:#ccc;" onmouseover="this.style.background='#2a2a2e'"
                        onmouseout="this.style.background='transparent'">

                        <img :src="lang.flag" class="w-5 h-5 rounded-full flex-shrink-0">
                        <span x-text="lang.label"></span>

                    </button>
                </template>
            </div>

        </div>
    </div>
    <!-- Center Image (top + center) -->
    <a href="{{ url('/') }}" class="fixed left-1/2 transform -translate-x-1/2 z-40 block md:hidden">
        <img src="{{ asset('assets/logo/cineverse.png') }}" alt="Logo" class="w-32">
    </a>

    {{-- Mobile Sidebar --}}
    {{-- ✅ REMOVED nested x-data — sidebar now shares the parent headerComponent() scope --}}
    <div class="md:hidden">

        {{-- Hamburger --}}
        <button @click="open = true"
            class="fixed top-4 left-4 z-50 flex items-center justify-center w-10 h-10 rounded-full text-white shadow-lg cursor-pointer"
            style="background:#2a2a2e;">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Backdrop --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 z-40"
            style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); display: none;">
        </div>

        {{-- Sidebar Panel --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed top-0 left-0 h-full w-72 z-50 flex flex-col shadow-2xl"
            style="background: #1c1c1e; display: none;">

            {{-- Sidebar Header --}}
            <div class="flex items-center justify-between px-4 pt-5 pb-3">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/logo/cineverse.png') }}" alt="Logo" class="w-32">
                </a>
                <button @click="open = false" style="color:#666;">
                    <svg class="h-5 w-5 cursor-pointer hover:text-amber-200 transition-all duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Search Bar --}}
            <div class="mx-3 mb-3 relative" x-data="{
                query: '',
                results: [],
                searching: false,
                showResults: false,
                async search() {
                    if (this.query.trim().length < 2) {
                        this.results = [];
                        this.showResults = false;
                        return;
                    }
                    this.searching = true;
                    this.showResults = true;
                    try {
                        const res = await fetch(`/search?q=${encodeURIComponent(this.query)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        this.results = await res.json();
                    } catch (e) { this.results = []; }
                    this.searching = false;
                },
                clear() {
                    this.query = '';
                    this.results = [];
                    this.showResults = false;
                }
            }">
                <div class="flex items-center gap-2 rounded-xl px-3 py-2.5" style="background:#2a2a2e;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#666"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <input type="text" x-model="query" @input.debounce.300ms="search()"
                        @focus="if(results.length) showResults = true" @click.away="showResults = false"
                        placeholder="Search movies..." class="bg-transparent outline-none text-sm w-full"
                        style="color:#ccc;" />
                    <svg x-show="searching" class="animate-spin" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="#666" stroke-width="2">
                        <path d="M21 12a9 9 0 11-6.219-8.56" />
                    </svg>
                    <button x-show="query.length > 0 && !searching" @click="clear()" style="color:#555;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div x-show="showResults && results.length > 0" x-transition @click.away="showResults = false"
                    class="absolute left-0 right-0 mt-2 rounded-2xl overflow-hidden shadow-2xl z-50 p-3"
                    style="background:#1c1c1e; border: 0.5px solid #2e2e32; width: 320px;">
                    <p class="text-xs mb-2 px-1" style="color:#555;">Results for "<span x-text="query"
                            style="color:#888;"></span>"</p>
                    <div class="flex flex-col gap-2">
                        <template x-for="movie in results" :key="movie.id">
                            <a :href="movie.url" @click="clear(); $root.open = false"
                                class="flex items-center gap-3 rounded-xl p-2 transition-colors duration-150 cursor-pointer"
                                onmouseover="this.style.background='#2a2a2e'"
                                onmouseout="this.style.background='transparent'">
                                <img :src="movie.poster ?? '/assets/default-poster.jpg'" :alt="movie.title"
                                    class="w-12 h-16 object-cover rounded-lg flex-shrink-0" style="min-width:48px;"
                                    onerror="this.src='/assets/default-poster.jpg'">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate" style="color:#fff;" x-text="movie.title">
                                    </p>
                                    <p class="text-xs mt-0.5" style="color:#888;" x-text="movie.genre ?? ''"></p>
                                    <p class="text-xs mt-0.5" style="color:#666;"
                                        x-text="movie.duration ? Math.floor(movie.duration/60)+'h '+(movie.duration%60)+'m' : ''">
                                    </p>
                                    <div class="flex mt-1"><span style="color:#facc15; font-size:11px;">★ ★ ★ ★
                                            ☆</span></div>
                                </div>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="#555" stroke-width="2" class="flex-shrink-0">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </a>
                        </template>
                    </div>
                    <a :href="`/movies?search=${query}`"
                        class="flex items-center justify-center gap-2 mt-3 py-2 rounded-xl text-xs transition-colors duration-150"
                        style="color:#7c6fe0; border: 0.5px solid #2e2e32;"
                        onmouseover="this.style.background='#2a2a2e'"
                        onmouseout="this.style.background='transparent'">
                        View all results
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </a>
                </div>

                <div x-show="showResults && !searching && results.length === 0 && query.length >= 2" x-transition
                    class="absolute left-0 right-0 mt-2 rounded-xl px-4 py-4 text-sm text-center shadow-xl"
                    style="background:#1c1c1e; border: 0.5px solid #2e2e32; color:#555;">
                    No movies found for "<span x-text="query" style="color:#888;"></span>"
                </div>
            </div>

            {{-- Nav Links for Mobile Screen --}}
            <nav class="flex flex-col gap-0.5 px-3 flex-1 overflow-y-auto">

                <a href="{{ url('/') }}" @click="active='/'; open=false"
                    :style="active === '/' ?
                        'background: linear-gradient(90deg,#3b2f6e 0%,transparent 100%); border-right: 2px solid #7c6fe0; color:#fff;' :
                        'color:#aaa;'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:text-white"
                    onmouseover="if(this.getAttribute('data-active')!=='true') this.style.background='#2a2a2e'"
                    onmouseout="if(this.getAttribute('data-active')!=='true') this.style.background='transparent'"
                    :data-active="active === '/'">
                    {{-- <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z" />
                    </svg> --}}
                    <img class="w-4 h-4 flex-shrink-0" src="https://img.icons8.com/clouds/100/home-page.png"
                        alt="home-page" />
                    <span x-text="translations.home"></span>
                </a>

                <a href="{{ url('/movies') }}" @click="active='movies'; open=false"
                    :style="active === 'movies' ?
                        'background: linear-gradient(90deg,#3b2f6e 0%,transparent 100%); border-right: 2px solid #7c6fe0; color:#fff;' :
                        'color:#aaa;'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:text-white"
                    onmouseover="if(this.getAttribute('data-active')!=='true') this.style.background='#2a2a2e'"
                    onmouseout="if(this.getAttribute('data-active')!=='true') this.style.background='transparent'"
                    :data-active="active === 'movies'">
                    <img class="w-4 h-4 flex-shrink-0" src="https://img.icons8.com/clouds/100/documentary.png"
                        alt="documentary" />
                    <span x-text="translations.movies"></span>
                </a>

                <a href="{{ url('/theaters') }}" @click="active='theaters'; open=false"
                    :style="active === 'theaters' ?
                        'background: linear-gradient(90deg,#3b2f6e 0%,transparent 100%); border-right: 2px solid #7c6fe0; color:#fff;' :
                        'color:#aaa;'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:text-white"
                    onmouseover="if(this.getAttribute('data-active')!=='true') this.style.background='#2a2a2e'"
                    onmouseout="if(this.getAttribute('data-active')!=='true') this.style.background='transparent'"
                    :data-active="active === 'theaters'">
                    <img class="w-4 h-4 flex-shrink-0"
                        src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/64/external-theater-city-elements-flatart-icons-lineal-color-flatarticons.png"
                        alt="external-theater-city-elements-flatart-icons-lineal-color-flatarticons" />
                    <span x-text="translations.theaters"></span>
                </a>

                <a href="{{ url('/releases') }}" @click="active='releases'; open=false"
                    :style="active === 'releases' ?
                        'background: linear-gradient(90deg,#3b2f6e 0%,transparent 100%); border-right: 2px solid #7c6fe0; color:#fff;' :
                        'color:#aaa;'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:text-white"
                    onmouseover="if(this.getAttribute('data-active')!=='true') this.style.background='#2a2a2e'"
                    onmouseout="if(this.getAttribute('data-active')!=='true') this.style.background='transparent'"
                    :data-active="active === 'releases'">
                    <img src="{{ asset('assets/module/release.png') }}" alt=""
                        class="w-4 h-4 flex-shrink-0">
                    <span x-text="translations.releases"></span>
                </a>

            </nav>

            {{-- User Row --}}
            <div class="flex items-center gap-3 px-4 py-4" style="border-top: 0.5px solid #2e2e32;">
                @auth
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-semibold flex-shrink-0"
                        style="background:#5b4fcf;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs truncate" style="color:#777;">{{ Auth::user()->email }}</p>
                    </div>
                @endauth

                @guest
                    <a href="{{ url('/login') }}" @click="open=false"
                        class="flex items-center gap-3 text-sm transition-colors duration-200" style="color:#aaa;">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span x-text="translations.login"></span>
                    </a>
                @endguest
            </div>

        </div>
    </div>

</header>
