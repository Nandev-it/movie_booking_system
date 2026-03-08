<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Movie Booking')</title>
    @vite('resources/css/app.css')
</head>

<body style="background-image: url('{{ asset('assets/bg-venom.png') }}');"
    class="backdrop-blur-sm bg-cover bg-center bg-no-repeat h-screen">

    @include('components.header')

    <main class="py-6 max-w-7xl mx-auto px-4">
        @yield('content')
    </main>

    {{-- @include('components.footer') --}}
</body>

</html>
