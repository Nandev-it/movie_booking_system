<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Movie Booking')</title>

    @vite('resources/css/app.css')

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/icons/logo.png') }}" type="image/x-icon">

    {{-- Link fort css --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;300;400;700;900&family=Cinzel:wght@400..900&family=Dangrek&family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&family=Hanuman:wght@100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Libertinus+Serif:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Noto+Sans+Khmer:wght@100..900&family=Noto+Serif+Khmer:wght@100..900&family=Roboto+Slab:wght@100..900&family=Suwannaphum:wght@100;300;400;700;900&display=swap"
        rel="stylesheet">
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

        <main class="py-25 max-w-7xl mx-auto px-4 suwannaphum-thin ">
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

    <style>
        .suwannaphum-thin {
            font-family: "Suwannaphum", serif;
            font-weight: 100;
            font-style: normal;
        }
    </style>



</body>

</html>
