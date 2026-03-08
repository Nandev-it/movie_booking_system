{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NanFlex</title>
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}
</head>

<body class="h-screen w-screen relative bg-black">

    @if (session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif
    {{-- @php
    dd(bcrypt('nan1111$$'))
@endphp --}}
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('assets/bg-venom.png') }}" alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div> <!-- Dark overlay -->
    </div>

    {{-- <div x-data="{ activeTab: 'login' }" class="relative z-10 flex items-center justify-center h-screen px-4">
    <div class="bg-white/10 backdrop-blur-sm rounded-lg shadow-lg w-full max-w-md p-8"></div> --}}

    <div x-data="{ activeTab: 'login' }" class="relative z-10 flex items-center justify-center h-screen px-4">
        <div class="bg-white/10 backdrop-blur-sm rounded-lg shadow-lg w-full max-w-md p-8 h-[420px] z-50">

            {{-- Logo --}}
            <div class="flex justify-center mb-6">
                {{-- <img src="{{ asset('assets/logo.png') }}" alt="UFlix" class="h-12 w-12"> --}}
            </div>

            {{-- Tabs --}}
            <div class="relative flex justify-center mb-6 text-lg font-semibold text-white">
                <button x-ref="login" @click="activeTab = 'login'" class="px-4 relative transition-all duration-300"
                    :class="activeTab === 'login' ? 'text-white' : 'text-gray-500'">Login</button>

                <button x-ref="signup" @click="activeTab = 'signup'" class="px-4 relative transition-all duration-300"
                    :class="activeTab === 'signup' ? 'text-white' : 'text-gray-500'">Signup</button>

                {{-- Animated Underline --}}
                <span class="absolute bottom-0 h-1 bg-purple-500 rounded-full transition-all duration-300"
                    :style="activeTab === 'login'
                        ?
                        'left: ' + $refs.login.offsetLeft + 'px; width: ' + $refs.login.offsetWidth + 'px' :
                        'left: ' + $refs.signup.offsetLeft + 'px; width: ' + $refs.signup.offsetWidth + 'px'">
                </span>
            </div>

            {{-- Description --}}
            <p class="text-gray-400 text-sm mb-6 text-center">
                <span x-show="activeTab === 'login'" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4">
                    Login to access your account.
                </span>
                <span x-show="activeTab === 'signup'" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4">
                    Signup to create a new account.
                </span>
            </p>

            {{-- Forms Container --}}
            <div class="relative h-auto w-full">

                {{-- Login Form --}}
                <form x-show="activeTab === 'login'" x-transition:enter="transition ease-out duration-500 transform"
                    x-transition:enter-start="opacity-0 -translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-500 transform"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-full" action="{{ url('/user_login') }}" method="POST"
                    class="space-y-4 absolute inset-0">
                    @csrf
                    <div class="relative">
                        <input type="email" name="email" placeholder="Email Address"
                            class="w-full rounded-lg py-3 px-4 bg-gray-800 text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <div class="absolute right-3 top-3 text-gray-400">
                            <img src="{{ asset('assets/icons/email.png') }}" alt="Email" class="w-6 h-6">
                        </div>
                    </div>

                    <div class="relative">
                        <input type="password" name="password" placeholder="Password"
                            class="w-full py-3 px-4 rounded-lg bg-gray-800 text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <div class="absolute right-3 top-3 text-gray-400">
                            <img src="{{ asset('assets/icons/password.png') }}" alt="Password" class="w-6 h-6">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-gray-400 text-sm">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-purple-500">
                            <span>Remember Me</span>
                        </label>
                        <a href="{{ url('maintenance') }}" class="hover:text-purple-500">Forget Password</a>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-purple-500 hover:bg-purple-600 rounded-full text-white font-semibold transition duration-300">
                        LOGIN
                    </button>
                </form>

                {{-- Signup Form --}}
                <form x-show="activeTab === 'signup'" x-transition:enter="transition ease-out duration-500 transform"
                    x-transition:enter-start="opacity-0 translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-500 transform"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-full" action="{{ url('/user_register') }}"
                    method="POST" class="space-y-4 absolute inset-0">
                    @csrf
                    <div class="relative">
                        <input type="text" name="name" placeholder="Full Name"
                            class="w-full rounded-lg py-3 px-4 bg-gray-800 text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <div class="absolute right-3 top-3 text-gray-400">
                            <img src="{{ asset('assets/icons/username.png') }}" alt="User" class="w-6 h-6">
                        </div>
                    </div>

                    <div class="relative">
                        <input type="email" name="email" placeholder="Email Address"
                            class="w-full rounded-lg py-3 px-4 bg-gray-800 text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <div class="absolute right-3 top-3 text-gray-400">
                            <img src="{{ asset('assets/icons/email.png') }}" alt="Email" class="w-6 h-6">
                        </div>
                    </div>

                    <div class="relative">
                        <input type="password" name="password" placeholder="Password"
                            class="w-full py-3 px-4 rounded-lg bg-gray-800 text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <div class="absolute right-3 top-3 text-gray-400">
                            <img src="{{ asset('assets/icons/password.png') }}" alt="Password" class="w-6 h-6">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-purple-500 hover:bg-purple-600 rounded-full text-white font-semibold transition duration-300">
                        SIGNUP
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <!-- Alpine.js -->

    <!-- Footer -->
    <footer class="absolute bottom-6 w-full text-center text-gray-400 text-sm z-10">
        {{-- <div class="flex justify-center space-x-2 mb-2">
            <img src="{{ asset('assets/logo.png') }}" alt="UFlix" class="h-6 w-6">
            <span>UFlix</span>
        </div> --}}
        <div class="space-x-4 mb-2">
            <a href="#" class="hover:text-purple-500">Blog</a>
            <a href="#" class="hover:text-purple-500">Contact</a>
            <a href="#" class="hover:text-purple-500">Browse Movies</a>
            <a href="#" class="hover:text-purple-500">Requests</a>
            <a href="#" class="hover:text-purple-500">Login</a>
        </div>
        <div class="flex justify-center space-x-4">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </footer>

</body>

</html>
