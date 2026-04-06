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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
            {{-- @include('components.cardmovie') --}}
        </main>

        {{-- @include('components.footer') --}}

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    {{-- ✅ Alpine.js for dynamic components --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function headerComponent() {
            return {
                scrolled: false,
                langOpen: false,
                open: false,
                active: '{{ request()->path() == '/' ? '/' : request()->segment(1) }}',
                locale: '{{ session('locale', app()->getLocale()) }}',
                translations: @json(__('messages')),

                languages: {
                    en: {
                        label: "English",
                        flag: "/assets/lang/en.png"
                    },
                    kh: {
                        label: "Khmer",
                        flag: "/assets/lang/kh.png"
                    },
                    kr: {
                        label: "Korean",
                        flag: "/assets/lang/kr.png"
                    },
                    jp: {
                        label: "Japanese",
                        flag: "/assets/lang/jp.png"
                    },
                },

                init() {
                    window.addEventListener('scroll', () => {
                        this.scrolled = window.scrollY > 50;
                    });
                },

                changeLang(lang) {
                    this.locale = lang;
                    this.langOpen = false;

                    fetch('/set-language', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                locale: lang
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.translations) {
                                this.translations = {
                                    ...data.translations
                                };
                                // Dispatch event to notify other components
                                window.dispatchEvent(new CustomEvent('language-changed', {
                                    detail: { locale: lang, translations: data.translations }
                                }));
                            }
                        });
                }
            }
        }

        AOS.init({
            duration: 800,
            once: false,
            mirror: true
        });
    </script>



    <style>
        [x-cloak] {
            display: none;
        }

        .suwannaphum-thin {
            font-family: "Suwannaphum", serif;
            font-weight: 100;
            font-style: normal;
        }

        @keyframes playPulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }

            50% {
                transform: scale(1.2);
                box-shadow: 0 0 20px 8px rgba(255, 255, 255, 0.2);
            }
        }

        .animate-play {
            animation: playPulse 1.5s infinite ease-in-out;
        }
    </style>



</body>

</html>
