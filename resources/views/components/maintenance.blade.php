<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Maintenance')</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-white">

    <!-- Background Blur -->
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-purple-500 opacity-40 blur-[160px] rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-300 opacity-40 blur-[160px] rounded-full">
        </div>
    </div>

    <!-- Content -->
    <div class="text-center px-6">

        <!-- Logo -->
        <h1 class="text-3xl font-bold text-black mb-6">
            Nan<span class="text-purple-500">Flex</span>
        </h1>

        <!-- Title -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Sorry! We're under construction maintenance!
        </h2>

        <!-- Description -->
        <p class="text-gray-600 mb-8">
            Our website is currently undergoing scheduled maintenance.
            We will be back soon! Thank you for being patient.
            Contact us for more information.
        </p>




        <!-- Social icons -->
        <div class="flex justify-center gap-4 mb-6">

            <a href="" class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center">
                <img src="{{ asset('assets/icons/fb.png') }}" alt="Facebook">
            </a>
            <a href="https://t.me/nan_fullstack" class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center">
                <img src="{{ asset('assets/icons/tg.png') }}" alt="Telegram">
            </a>
            <a href="" class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center">
                <img src="{{ asset('assets/icons/tiktok.png') }}" alt="Instagram">
            </a>

        </div>

        <!-- Email -->
        <p class="text-sm text-gray-700">
            nanflex@gmail.com
        </p>


        <div class="block mt-6">
            <button class=" px-6 py-2 rounded-xl border border-purple-400 hover:shadow hover:text-purple-500 transition duration-300"><a href="{{ url('/') }}">Back to Home</a></button>
        </div>

    </div>


</body>

</html>
