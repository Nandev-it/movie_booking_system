
@extends('layouts.app')

@section('content')
@php
    $movies = \App\Models\Movie::latest()->get();
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-white text-xl font-semibold">
            Top <span class="text-purple-400">Airing Movies</span>
        </h2>
        <a href="{{ url('/movies') }}" class="text-sm text-gray-400 hover:text-white transition">
            See all ›
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">

        @forelse ($movies as $movie)
            <a href="{{ url('/movies/' . $movie->id) }}"
                class="group block rounded-2xl overflow-hidden cursor-pointer" data-aos="zoom-in">

                {{-- Poster with overlays --}}
                <div class="relative">
                    <img
                        src="{{ $movie->poster ? asset($movie->poster) : 'https://static.wikia.nocookie.net/marveldatabase/images/b/b3/All-New_Venom_Vol_1_1_Lee_Virgin_Variant.jpg/revision/latest?cb=20241206180423' }}"
                        alt="{{ $movie->title }}"
                        class="w-full object-cover rounded-2xl h-[220px] md:h-[280px] lg:h-[300px] group-hover:scale-110 transition-transform duration-500">

                    {{-- Dark gradient overlay at bottom --}}
                    <div class="absolute inset-0 rounded-2xl"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);">
                    </div>

                    {{-- Duration badge top-right --}}
                    <div class="absolute top-2 right-2 flex items-center gap-1 px-2 py-1 rounded-lg text-xs text-white font-medium"
                        style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}m
                    </div>

                    {{-- Genre badge top-left --}}
                    <div class="absolute top-2 left-2 px-2 py-1 rounded-lg text-xs font-medium"
                        style="background: rgba(91,79,207,0.8); color:#fff; backdrop-filter: blur(4px);">
                        {{ $movie->genre ?? 'Movie' }}
                    </div>

                    {{-- Title at bottom of image --}}
                    <div class="absolute bottom-0 left-0 right-0 px-3 pb-3">
                        <h3 class="text-white text-sm font-semibold line-clamp-1">
                            {{ $movie->title }}
                        </h3>
                        <p class="text-gray-300 text-xs mt-0.5">
                            {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('M Y') : '' }}
                        </p>
                    </div>
                </div>

            </a>

        @empty
            <div class="col-span-5 text-center text-gray-400 py-20">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4"/>
                </svg>
                <p class="text-lg">No movies available yet.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection
