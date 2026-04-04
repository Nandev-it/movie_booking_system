@php
    $movies = \App\Models\Movie::latest()->get();
@endphp
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">

        @forelse ($movies as $movie)
            <div class="bg-black/40 backdrop-blur-md rounded-3xl overflow-hidden hover:scale-105 transition duration-300">

                {{-- Poster --}}
                <img
                    src="{{ $movie->poster ? asset($movie->poster) : asset('assets/default-poster.jpg') }}"
                    alt="{{ $movie->title }}"
                    class="w-full md:max-h-[320px] sm:max-h-[250px] object-cover rounded-t-3xl">

                {{-- Content --}}
                <div class="p-4 text-center text-white">

                    <h2 class="text-lg font-semibold line-clamp-1">
                        {{ $movie->title }}
                    </h2>

                    <p class="text-gray-400 text-sm mt-1">
                        {{ $movie->genre ?? 'N/A' }}
                    </p>

                    <p class="text-gray-400 text-sm">
                        {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}mins
                    </p>

                    {{-- Stars (static for now) --}}
                    <div class="flex justify-center mt-2 text-yellow-400 text-lg">
                        ★ ★ ★ ★ ☆
                    </div>

                    <p class="text-gray-400 text-sm mt-1">
                        {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('M d, Y') : '' }}
                    </p>

                    {{-- Button --}}
                    <button class="mt-4 w-full bg-gray-700 hover:bg-gray-600 text-white py-2 rounded-full transition duration-300">
                        <a href="{{ url('/movies/' . $movie->id) }}">Buy Ticket</a>
                    </button>

                </div>
            </div>

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
