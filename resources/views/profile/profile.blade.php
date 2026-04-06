@extends('layouts.app')

@section('title', 'Profile - ' . Auth::user()->name)

@section('content')
    <div class="min-h-screen text-white py-8">
        <div class="max-w-2xl mx-auto px-4">

            {{-- Profile Card --}}
            <div class="bg-gradient-to-b from-gray-900/80 to-gray-900 rounded-3xl p-8 mb-6 text-center">

                {{-- Avatar --}}
                <div class="flex justify-center mb-6">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-purple-500 flex items-center justify-center bg-gradient-to-br from-purple-600 to-blue-600">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Name --}}
                <h1 class="text-3xl font-bold mb-2">
                    {{ Auth::user()->name }}
                </h1>

                {{-- Email --}}
                <p class="text-gray-400 text-sm mb-6">
                    {{ Auth::user()->email }}
                </p>

                {{-- Edit Profile Button --}}
                <a href="{{ url('/profile/edit') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit Profile
                </a>

            </div>

            {{-- Settings List --}}
            <div class="space-y-3">

                {{-- Playback Speed --}}
                <a href="#"
                    class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl hover:bg-gray-800/50 transition-colors border border-white/10">
                    <div class="flex items-center gap-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-400">
                            <polygon points="23 7 16 12 23 17 23 7" />
                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2" />
                        </svg>
                        <span class="font-medium">Playback Speed</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400">
                        <span>1x (Normal)</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </div>
                </a>

                {{-- Notifications --}}
                <a href="#"
                    class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl hover:bg-gray-800/50 transition-colors border border-white/10">
                    <div class="flex items-center gap-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-400">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <span class="font-medium">Notifications</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400">
                        <span>On</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </div>
                </a>

                {{-- Language --}}
                <a href="#"
                    class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl hover:bg-gray-800/50 transition-colors border border-white/10">
                    <div class="flex items-center gap-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-400">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M2 12h20" />
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg>
                        <span class="font-medium">Language</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400">
                        <span>{{ session('locale', 'en') === 'en' ? '🇺🇸 English' : (session('locale') === 'kh' ? '🇰🇭 Khmer' : (session('locale') === 'kr' ? '🇰🇷 Korean' : '🇯🇵 Japanese')) }}</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </div>
                </a>

                {{-- Download Options --}}
                <a href="#"
                    class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl hover:bg-gray-800/50 transition-colors border border-white/10">
                    <div class="flex items-center gap-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-400">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span class="font-medium">Download Options</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400">
                        <span>Wi-Fi Only</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </div>
                </a>

                {{-- Watch History --}}
                <a href="#"
                    class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl hover:bg-gray-800/50 transition-colors border border-white/10">
                    <div class="flex items-center gap-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-400">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        <span class="font-medium">Watch History</span>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </a>

                {{-- Help & Support --}}
                <a href="#"
                    class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl hover:bg-gray-800/50 transition-colors border border-white/10">
                    <div class="flex items-center gap-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-400">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4" />
                            <path d="M12 8h.01" />
                        </svg>
                        <span class="font-medium">Help & Support</span>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </a>

                {{-- Logout --}}
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-between p-4 bg-red-900/20 rounded-2xl hover:bg-red-900/30 transition-colors border border-red-700/30 text-red-400">
                        <div class="flex items-center gap-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </div>
                    </button>
                </form>

            </div>

        </div>
    </div>
@endsection
