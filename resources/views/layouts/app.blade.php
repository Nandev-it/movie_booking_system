<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Movie Booking')</title>

    @vite('resources/css/app.css')

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/icons/logo.png') }}" type="image/x-icon">
</head>

<body style="background-image: url('{{ asset('assets/bg-venom.png') }}');"
    class="bg-cover bg-center bg-no-repeat min-h-screen">

    <!-- ❌ Desktop Block Message -->
    {{-- <div class="hidden lg:flex h-screen items-center justify-center bg-black/80 text-white text-center px-6">
        <div>
            <h1 class="text-3xl font-bold mb-4">
                Mobile Only Website
            </h1>
            <p class="text-lg text-gray-300">
                Please open this movie booking system on a mobile phone or tablet.
            </p>
        </div>
    </div> --}}

    <!-- ✅ Mobile / Tablet Layout -->
    {{-- If want to hide desktop layout add lg:hidden --}}
    <div class=" bg-black/80 text-white min-h-screen">

        @include('components.header')

        <main class="py-6 max-w-7xl mx-auto px-4">
            @yield('content')
            @include('components.cardmovie')
        </main>

        {{-- @include('components.footer') --}}

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

</body>

</html>
