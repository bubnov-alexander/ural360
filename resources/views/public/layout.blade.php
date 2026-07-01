<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page?->getSeoTitle() ?? $settings['siteName'] }}</title>
    @if($page?->getSeoDescription())
        <meta name="description" content="{{ $page->getSeoDescription() }}">
    @endif
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="{{ asset('legacy-theme/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/assets/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/assets/css/fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/assets/css/nouislider.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/hero-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/advantages-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/service-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/products-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/about-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/gallery-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/rental-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/paydel-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/faq-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/inc/blocks/contacts-block/block.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-theme/assets/css/laravel-overrides.css') }}">
</head>
<body class="@yield('body_class', 'home page-template-front-page') skeleton-loading">
    @include('public.partials.skeleton')
    @include('public.partials.header')

    <main id="main" class="@yield('main_class', 'front-page')">
        @yield('content')
    </main>

    @include('public.partials.footer')

    <script src="{{ asset('legacy-theme/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('legacy-theme/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('legacy-theme/assets/js/swiper.js') }}"></script>
    <script src="{{ asset('legacy-theme/assets/js/fancybox.min.js') }}"></script>
    <script src="{{ asset('legacy-theme/assets/js/inputmask.js') }}"></script>
    <script src="{{ asset('legacy-theme/assets/js/modules/mobileMenu.js') }}"></script>
    <script src="{{ asset('legacy-theme/assets/js/modules/themeModal.js') }}"></script>
    <script src="{{ asset('legacy-theme/assets/js/main.js') }}"></script>
    <script src="{{ asset('legacy-theme/inc/blocks/gallery-block/block.js') }}"></script>
    <script>
        (function () {
            var done = function () {
                document.body.classList.add('skeleton-ready');
                window.setTimeout(function () {
                    document.body.classList.remove('skeleton-loading');
                }, 350);
            };

            if (document.readyState === 'complete') {
                done();
                return;
            }

            window.addEventListener('load', done, { once: true });
            window.setTimeout(done, 1800);
        })();
    </script>
    @stack('scripts')
</body>
</html>
