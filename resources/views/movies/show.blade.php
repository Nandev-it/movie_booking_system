@extends('layouts.app')

@section('content')
    <div x-data="{ open: false }" class="min-h-screen text-white flex justify-center items-center py-6" data-aos="zoom-in">

        <div class="w-[380px] md:w-[420px] bg-gray-900 rounded-[30px] overflow-hidden shadow-2xl relative">

            {{-- 🎥 Poster OR Video --}}
            <div class="relative">

                {{-- Poster (before click) --}}
                <template x-if="!open">
                    <div class="relative">
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
                                        class="relative w-16 h-16 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-xl">
                                        ▶
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </template>

                {{-- Video (after click) --}}
                <template x-if="open">
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
                </template>

            </div>

            {{-- Info Card --}}
            <div class="px-5 pt-4 pb-6 bg-gradient-to-b from-black/80 to-gray-900 rounded-t-[30px] -mt-10 relative z-10">

                {{-- Title --}}
                <h2 class="text-2xl font-bold">
                    {{ $movie->title }}
                    <span class="text-xs bg-gray-700 px-1 py-0.5 rounded ml-1">HD</span>
                </h2>

                {{-- <p class="text-gray-400 text-sm mt-1">
                {{ $movie->tagline ?? 'No tagline available' }}
            </p> --}}

                {{-- Tags --}}
                <div class="flex items-center gap-2 mt-4 text-xs">
                    <span class="bg-gray-800 px-3 py-1 rounded-full">
                        {{ $movie->genre ?? 'Movie' }}
                    </span>

                    {{-- <span class="bg-gray-800 px-3 py-1 rounded-full">
                    16+
                </span> --}}

                    <span class="bg-gray-800 px-3 py-1 rounded-full flex items-center gap-1">
                        ⭐ {{ $movie->rating ?? '4.0' }}
                    </span>

                    @if ($movie->duration)
                        <span class="bg-gray-800 px-3 py-1 rounded-full">
                            {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}min
                        </span>
                    @endif

                    {{-- <div class="ml-auto flex gap-3 text-gray-400">
                        <button class="hover:text-white">✈</button>
                        <button class="hover:text-red-500">♡</button>
                    </div> --}}
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
                        <p>Release: {{ \Carbon\Carbon::parse($movie->release_date)->format('M Y') }}</p>
                    @endif
                </div>

                {{-- Cast --}}
                {{-- <div class="mt-5">
                <h3 class="text-sm font-semibold mb-2">Star Cast</h3>

                <div class="flex gap-3 overflow-x-auto pb-2">

                    @forelse($movie->casts ?? [] as $cast)
                        <div class="min-w-[80px]">
                            <img src="{{ $cast->image }}"
                                 class="w-full h-[100px] object-cover rounded-xl">
                            <p class="text-xs text-gray-400 mt-1 truncate">
                                {{ $cast->name }}
                            </p>
                        </div>
                    @empty
                        @for ($i = 0; $i < 5; $i++)
                            <div class="min-w-[80px]">
                                <img src="https://via.placeholder.com/100x120"
                                     class="w-full h-[100px] object-cover rounded-xl">
                            </div>
                        @endfor
                    @endforelse

                </div>
            </div> --}}

            </div>

            {{-- Bottom Navigation --}}
            {{-- <div
                class="absolute bottom-0 left-0 right-0 bg-black/80 backdrop-blur-md flex justify-around py-3 text-gray-400">
                <span class="text-white">🏠</span>
                <span>●</span>
                <span>🔥</span>
                <span>♡</span>
            </div> --}}

        </div>

    </div>
@endsection
