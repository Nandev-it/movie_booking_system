@extends('layouts.app')

@section('content')
    <div x-data="{
        open: false,
        watchNowText: '{{ __('messages.watchNow') }}',
        updateTranslations(newTranslations) {
            this.watchNowText = newTranslations.watchNow || '🎬 Watch Now';
            // Update all watch-now buttons
            const buttons = document.querySelectorAll('[data-watch-btn]');
            buttons.forEach(btn => {
                btn.textContent = this.watchNowText;
            });
        }
    }"
    @language-changed.window="updateTranslations($event.detail.translations)"
    class="min-h-screen text-white py-6" data-aos="zoom-in">

    {{-- MOBILE LAYOUT (single column) --}}
        <div class="md:hidden flex justify-center items-center px-4">
            <div class="w-full max-w-[420px] bg-gray-900 rounded-[30px] overflow-hidden shadow-2xl relative">

                {{-- 🎥 Poster OR Video --}}
                <div class="relative">

                    {{-- Poster (before click) --}}
                    <div x-show="!open">
                        <img src="{{ $movie->poster ?? 'https://via.placeholder.com/500x700' }}"
                            class="w-full h-[420px] object-cover">

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>

                        {{-- Play Button --}}
                        @if ($movie->video_url)
                            <div class="absolute inset-0 flex items-center justify-center cursor-pointer">
                                <div class="relative flex items-center justify-center">
                                    <span class="absolute w-20 h-20 rounded-full bg-white/20 animate-ping"></span>

                                    <button @click="open = true"
                                        class="relative w-16 h-16 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-xl hover:bg-white/40 transition-colors">
                                        <img width="32" height="32" src="{{ asset('assets/module/play.png') }}" alt="play" />
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Video (after click) --}}
                    <div x-show="open" style="display: none;">
                        <div class="relative w-full h-[420px] bg-black">

                            {{-- Close button --}}
                            <button @click="open = false"
                                class="absolute top-3 right-3 z-10 bg-black/60 px-3 py-1 rounded text-white text-sm">
                                ✕
                            </button>

                            <iframe class="w-full h-full"
                                src="{{ str_contains($movie->video_url, 'watch?v=')
                                    ? str_replace('watch?v=', 'embed/', $movie->video_url)
                                    : $movie->video_url }}?autoplay=1"
                                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                </div>

                {{-- Info Card --}}
                <div class="px-5 pt-4 pb-6 bg-gradient-to-b from-black/80 to-gray-900 rounded-t-[30px] -mt-10 relative z-10">

                    {{-- Title --}}
                    <h2 class="text-2xl font-bold">
                        {{ $movie->title }}
                        <span class="text-xs bg-gray-700 px-1 py-0.5 rounded ml-1">HD</span>
                    </h2>

                    {{-- Tags --}}
                    <div class="flex items-center gap-2 mt-4 text-xs flex-wrap">
                        <span class="bg-gray-800 px-3 py-1 rounded-full">
                            {{ $movie->genre ?? 'Movie' }}
                        </span>

                        <span class="bg-gray-800 px-3 py-1 rounded-full flex items-center gap-1">
                            ⭐ {{ $movie->rating ?? '4.0' }}
                        </span>

                        @if ($movie->duration)
                            <span class="bg-gray-800 px-3 py-1 rounded-full">
                                {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}min
                            </span>
                        @endif
                    </div>

                    {{-- Story --}}
                    <div class="mt-5">
                        <h3 class="text-sm font-semibold mb-1">Story Line</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            {{ $movie->description ?? 'No description available.' }}
                        </p>
                    </div>

                    {{-- Extra Info --}}
                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                        @if ($movie->release_date)
                            <p>Release: {{ \Carbon\Carbon::parse($movie->release_date)->format('M Y D') }}</p>
                        @endif
                    </div>

                    {{-- Watch Button (Mobile) --}}
                    <div class="pt-6">
                        <button data-watch-btn class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-all">
                            {{ __('messages.watchNow') }}
                        </button>
                    </div>

                </div>

            </div>
        </div>

        {{-- DESKTOP LAYOUT (two columns) --}}
        <div class="hidden md:flex justify-center px-4">
            <div class="w-full max-w-7xl flex gap-8 items-start">

                {{-- LEFT: Video/Poster --}}
                <div class="flex-shrink-0 w-[450px]">
                    <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-2xl relative">

                        {{-- Poster (before click) --}}
                        <div x-show="!open">
                            <img src="{{ $movie->poster ?? 'https://via.placeholder.com/500x700' }}"
                                class="w-full h-[600px] object-cover">

                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>

                            {{-- Play Button --}}
                            @if ($movie->video_url)
                                <div class="absolute inset-0 flex items-center justify-center cursor-pointer">
                                    <div class="relative flex items-center justify-center">
                                        <span class="absolute w-24 h-24 rounded-full bg-white/20 animate-ping"></span>

                                        <button @click="open = true"
                                            class="relative w-20 h-20 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-3xl hover:bg-white/40 transition-colors">
                                            <img width="40" height="40" src="https://img.icons8.com/puffy/64/play.png" alt="play" />
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Video (after click) --}}
                        <div x-show="open" style="display: none;">
                            <div class="relative w-full h-[600px] bg-black">

                                {{-- Close button --}}
                                <button @click="open = false"
                                    class="absolute top-3 right-3 z-10 bg-black/60 px-4 py-2 rounded text-white text-sm hover:bg-black/80 transition-colors">
                                    ✕ Close
                                </button>

                                <iframe class="w-full h-full"
                                    src="{{ str_contains($movie->video_url, 'watch?v=')
                                        ? str_replace('watch?v=', 'embed/', $movie->video_url)
                                        : $movie->video_url }}?autoplay=1"
                                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- RIGHT: Content/Description --}}
                <div class="flex-1">
                    <div class="bg-gradient-to-b from-gray-900/80 to-gray-900 rounded-2xl p-8 space-y-6">

                        {{-- Title --}}
                        <div>
                            <h1 class="text-4xl font-bold mb-2">
                                {{ $movie->title }}
                                <span class="text-sm bg-gray-700 px-2 py-1 rounded ml-3">HD</span>
                            </h1>
                            <p class="text-gray-400 text-lg">{{ $movie->tagline ?? '' }}</p>
                        </div>

                        {{-- Tags --}}
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="bg-gray-800 px-4 py-2 rounded-full text-sm font-medium">
                                {{ $movie->genre ?? 'Movie' }}
                            </span>

                            <span class="bg-gray-800 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                                ⭐ {{ $movie->rating ?? '4.0' }}/5
                            </span>

                            @if ($movie->duration)
                                <span class="bg-gray-800 px-4 py-2 rounded-full text-sm font-medium">
                                    ⏱️ {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}min
                                </span>
                            @endif

                            @if ($movie->release_date)
                                <span class="bg-gray-800 px-4 py-2 rounded-full text-sm font-medium">
                                    📅 {{ \Carbon\Carbon::parse($movie->release_date)->format('M Y') }}
                                </span>
                            @endif
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-700"></div>

                        {{-- Description --}}
                        <div>
                            <h3 class="text-xl font-bold mb-3">Story Line</h3>
                            <p class="text-gray-300 text-base leading-relaxed">
                                {{ $movie->description ?? 'No description available.' }}
                            </p>
                        </div>

                        {{-- Additional Info --}}
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            @if ($movie->director)
                                <div>
                                    <p class="text-gray-500 text-sm">Director</p>
                                    <p class="text-white font-medium">{{ $movie->director }}</p>
                                </div>
                            @endif

                            @if ($movie->release_year)
                                <div>
                                    <p class="text-gray-500 text-sm">Release Year</p>
                                    <p class="text-white font-medium">{{ $movie->release_year }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Watch Button (Desktop) --}}
                        <div class="pt-6">
                            <button data-watch-btn class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-all">
                                {{ __('messages.watchNow') }}
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
