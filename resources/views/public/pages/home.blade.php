@extends('public.layout')

@section('content')
    <div id="hero-block" class="alignwide">
        <div class="hero-image-bg">
            <img src="{{ $hero['backgroundImage'] }}" alt="">
        </div>
        <div class="container">
            <div class="hero">
                <div class="hero__content">
                    <h1 class="hero__title">{{ $hero['title'] }}</h1>
                    <p class="hero__desc">{{ $hero['description'] }}</p>
                    <div class="paramms params_mobile">
                        @foreach($hero['params'] as $param)
                            <div class="paramm @if($loop->first) first_paramm @endif">{{ $param }}</div>
                        @endforeach
                    </div>
                    <a href="#service-block" class="btn">Перейти к услугам</a>
                </div>
                <div class="paramms">
                    @foreach($hero['params'] as $param)
                        <div class="paramm @if($loop->first) first_paramm @endif">{{ $param }}</div>
                    @endforeach
                </div>
                @if(!empty($hero['image']))
                    <div class="hero__image">
                        <img src="{{ $hero['image'] }}" alt="">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="advantages-block" class="alignwide">
        <div class="container">
            <div class="advantages">
                @foreach($advantages as $advantage)
                    <div class="item">
                        <div class="item__icon"><img src="{{ $advantage['icon'] }}" alt=""></div>
                        <span class="item__text">{{ $advantage['title'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="service-block" class="alignwide">
        <div class="container">
            <div class="row">
                <h2 class="block-title">Наши услуги</h2>
                <a href="/service" class="block-link btn__link">
                    Смотреть все услуги
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.02919 5.00551L7.03046 5.30059C7.0406 6.47098 7.11115 7.51522 7.23283 8.17698C7.23283 8.18891 7.36555 8.84524 7.4501 9.0637C7.58282 9.37947 7.82282 9.64751 8.12373 9.81733C8.36463 9.9385 8.61736 10 8.8819 10C9.08985 9.99036 9.4328 9.88572 9.67757 9.79798L9.88098 9.72003C11.2282 9.18487 13.8037 7.4362 14.79 6.36681L14.8627 6.29206L15.1873 5.9418C15.3918 5.67377 15.5 5.34606 15.5 4.99357C15.5 4.6778 15.4036 4.36203 15.2109 4.10685C15.1532 4.02417 15.0603 3.91811 14.9776 3.82849L14.6617 3.49782C13.5746 2.39643 11.221 0.851526 10.001 0.339637C10.001 0.328621 9.2428 0.0119332 8.8819 0H8.83372C8.28009 0 7.76282 0.31577 7.49828 0.826143C7.42601 0.965669 7.35669 1.23898 7.30396 1.47903L7.20919 1.93226C7.10101 2.6611 7.02919 3.77914 7.02919 5.00551ZM1.75271 3.73472C1.0609 3.73472 0.5 4.30108 0.5 4.99963C0.5 5.69818 1.0609 6.26455 1.75271 6.26455L4.8354 5.99192C5.37812 5.99192 5.81812 5.54856 5.81812 4.99963C5.81812 4.45162 5.37812 4.00734 4.8354 4.00734L1.75271 3.73472Z" fill="#333333"/>
                    </svg>
                </a>
            </div>
            <div class="service">
                @foreach($services as $service)
                    <a href="{{ $service['url'] }}" class="item">
                        <div class="item__wrap">
                            <h3 class="item__name">{{ $service['title'] }}</h3>
                            <button class="item__btn btn__link">Узнать подробнее</button>
                        </div>
                        @if(!empty($service['image']))
                            <div class="item__image">
                                <img src="{{ $service['image'] }}" alt="{{ $service['imageAlt'] }}">
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div id="routes" class="products_block alignwide">
        <div class="produtc_cont" style="background:url('{{ $routesBackground }}') #f1f1f3;">
            <div class="container">
                <div class="block_head">
                    <h2 class="block-title first_paramm">Популярные маршруты</h2>
                </div>
            </div>
            <div class="container swiper swiper-container" id="gall_slider_home">
                <div class="products_container swiper-wrapper">
                    @foreach($tours as $tour)
                        <div class="product_item swiper-slide">
                            <li class="product type-product">
                                <a href="{{ $tour['url'] }}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                    @if(!empty($tour['image']))
                                        <div class="product-image">
                                            <img src="{{ $tour['image'] }}" alt="{{ $tour['imageAlt'] }}">
                                        </div>
                                    @endif
                                    <h2 class="woocommerce-loop-product__title">{{ $tour['title'] }}</h2>
                                    <div class="product-wrap">
                                        <div class="product_desc">{!! $tour['description'] !!}</div>
                                        <span class="btn">Забронировать</span>
                                    </div>
                                </a>
                            </li>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="nav" id="arrow_holder_home">
                <div class="nav__prev">
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.97081 4.99449L8.96954 4.69941C8.9594 3.52902 8.88885 2.48478 8.76717 1.82302C8.76717 1.81109 8.63445 1.15476 8.5499 0.936296C8.41718 0.620525 8.17718 0.352488 7.87627 0.18267C7.63537 0.0615015 7.38264 0 7.1181 0C6.91015 0.00963879 6.5672 0.114284 6.32243 0.202018L6.11902 0.279971C4.77177 0.815128 2.19634 2.5638 1.20999 3.63319L1.13727 3.70794L0.812723 4.0582C0.60818 4.32623 0.5 4.65394 0.5 5.00643C0.5 5.3222 0.596362 5.63797 0.789087 5.89315C0.846784 5.97583 0.93972 6.08189 1.02244 6.17151L1.33833 6.50218C2.42538 7.60357 4.77904 9.14847 5.99902 9.66036C5.99902 9.67138 6.7572 9.98807 7.1181 10H7.16628C7.71991 10 8.23718 9.68423 8.50172 9.17386C8.57399 9.03433 8.64331 8.76102 8.69604 8.52097L8.79081 8.06774C8.89899 7.3389 8.97081 6.22086 8.97081 4.99449ZM14.2473 6.26528C14.9391 6.26528 15.5 5.69892 15.5 5.00037C15.5 4.30182 14.9391 3.73545 14.2473 3.73545L11.1646 4.00808C10.6219 4.00808 10.1819 4.45144 10.1819 5.00037C10.1819 5.54838 10.6219 5.99266 11.1646 5.99266L14.2473 6.26528Z" fill="#fff"/>
                    </svg>
                </div>
                <div class="nav__next">
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.02919 5.00551L7.03046 5.30059C7.0406 6.47098 7.11115 7.51522 7.23283 8.17698C7.23283 8.18891 7.36555 8.84524 7.4501 9.0637C7.58282 9.37947 7.82282 9.64751 8.12373 9.81733C8.36463 9.9385 8.61736 10 8.8819 10C9.08985 9.99036 9.4328 9.88572 9.67757 9.79798L9.88098 9.72003C11.2282 9.18487 13.8037 7.4362 14.79 6.36681L14.8627 6.29206L15.1873 5.9418C15.3918 5.67377 15.5 5.34606 15.5 4.99357C15.5 4.6778 15.4036 4.36203 15.2109 4.10685C15.1532 4.02417 15.0603 3.91811 14.9776 3.82849L14.6617 3.49782C13.5746 2.39643 11.221 0.851526 10.001 0.339637C10.001 0.328621 9.2428 0.0119332 8.8819 0H8.83372C8.28009 0 7.76282 0.31577 7.49828 0.826143C7.42601 0.965669 7.35669 1.23898 7.30396 1.47903L7.20919 1.93226C7.10101 2.6611 7.02919 3.77914 7.02919 5.00551ZM1.75271 3.73472C1.0609 3.73472 0.5 4.30108 0.5 4.99963C0.5 5.69818 1.0609 6.26455 1.75271 6.26455L4.8354 5.99192C5.37812 5.99192 5.81812 5.54856 5.81812 4.99963C5.81812 4.45162 5.37812 4.00734 4.8354 4.00734L1.75271 3.73472Z" fill="#fff"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div id="about-block" class="alignwide">
        <div class="container">
            <h2 class="block-title">{{ $about['title'] }}</h2>
            <div class="about">
                <div class="about__advant">
                    <div class="about__advantages">
                        @foreach($about['stats'] as $stat)
                            <div class="item">
                                <div class="item__count">{{ $stat['value'] }}</div>
                                <p class="item__text">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    <button class="btn open-modal" data-modal="callback" type="button">Оставить заявку</button>
                </div>
                <div class="about__desc">
                    <p class="desc">{!! nl2br(e($about['description'])) !!}</p>
                    <a href="/about" class="btn__link">
                        Подробнее о компании
                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.02919 5.00551L7.03046 5.30059C7.0406 6.47098 7.11115 7.51522 7.23283 8.17698C7.23283 8.18891 7.36555 8.84524 7.4501 9.0637C7.58282 9.37947 7.82282 9.64751 8.12373 9.81733C8.36463 9.9385 8.61736 10 8.8819 10C9.08985 9.99036 9.4328 9.88572 9.67757 9.79798L9.88098 9.72003C11.2282 9.18487 13.8037 7.4362 14.79 6.36681L14.8627 6.29206L15.1873 5.9418C15.3918 5.67377 15.5 5.34606 15.5 4.99357C15.5 4.6778 15.4036 4.36203 15.2109 4.10685C15.1532 4.02417 15.0603 3.91811 14.9776 3.82849L14.6617 3.49782C13.5746 2.39643 11.221 0.851526 10.001 0.339637C10.001 0.328621 9.2428 0.0119332 8.8819 0H8.83372C8.28009 0 7.76282 0.31577 7.49828 0.826143C7.42601 0.965669 7.35669 1.23898 7.30396 1.47903L7.20919 1.93226C7.10101 2.6611 7.02919 3.77914 7.02919 5.00551ZM1.75271 3.73472C1.0609 3.73472 0.5 4.30108 0.5 4.99963C0.5 5.69818 1.0609 6.26455 1.75271 6.26455L4.8354 5.99192C5.37812 5.99192 5.81812 5.54856 5.81812 4.99963C5.81812 4.45162 5.37812 4.00734 4.8354 4.00734L1.75271 3.73472Z" fill="#333333"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($gallery['images']))
        <div id="gallery-block" class="alignwide">
        <div class="container">
            <div class="row">
                <h2 class="block-title">{{ $gallery['title'] }}</h2>
                <a href="/gallery" class="btn btn__invert">Смотреть полностью</a>
            </div>
            <div class="swiper gallery">
                <div class="swiper-wrapper">
                    @foreach($gallery['images'] as $image)
                        <div class="swiper-slide">
                            <div class="item">
                                <div class="item__img" data-fancybox="gallery-home" data-src="{{ $image['url'] }}">
                                    <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="nav">
                    <div class="swiper-pagination"></div>
                    <div class="nav__prev">
                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.97081 4.99449L8.96954 4.69941C8.9594 3.52902 8.88885 2.48478 8.76717 1.82302C8.76717 1.81109 8.63445 1.15476 8.5499 0.936296C8.41718 0.620525 8.17718 0.352488 7.87627 0.18267C7.63537 0.0615015 7.38264 0 7.1181 0C6.91015 0.00963879 6.5672 0.114284 6.32243 0.202018L6.11902 0.279971C4.77177 0.815128 2.19634 2.5638 1.20999 3.63319L1.13727 3.70794L0.812723 4.0582C0.60818 4.32623 0.5 4.65394 0.5 5.00643C0.5 5.3222 0.596362 5.63797 0.789087 5.89315C0.846784 5.97583 0.93972 6.08189 1.02244 6.17151L1.33833 6.50218C2.42538 7.60357 4.77904 9.14847 5.99902 9.66036C5.99902 9.67138 6.7572 9.98807 7.1181 10H7.16628C7.71991 10 8.23718 9.68423 8.50172 9.17386C8.57399 9.03433 8.64331 8.76102 8.69604 8.52097L8.79081 8.06774C8.89899 7.3389 8.97081 6.22086 8.97081 4.99449ZM14.2473 6.26528C14.9391 6.26528 15.5 5.69892 15.5 5.00037C15.5 4.30182 14.9391 3.73545 14.2473 3.73545L11.1646 4.00808C10.6219 4.00808 10.1819 4.45144 10.1819 5.00037C10.1819 5.54838 10.6219 5.99266 11.1646 5.99266L14.2473 6.26528Z" fill="#547b53"/>
                        </svg>
                    </div>
                    <div class="nav__next">
                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.02919 5.00551L7.03046 5.30059C7.0406 6.47098 7.11115 7.51522 7.23283 8.17698C7.23283 8.18891 7.36555 8.84524 7.4501 9.0637C7.58282 9.37947 7.82282 9.64751 8.12373 9.81733C8.36463 9.9385 8.61736 10 8.8819 10C9.08985 9.99036 9.4328 9.88572 9.67757 9.79798L9.88098 9.72003C11.2282 9.18487 13.8037 7.4362 14.79 6.36681L14.8627 6.29206L15.1873 5.9418C15.3918 5.67377 15.5 5.34606 15.5 4.99357C15.5 4.6778 15.4036 4.36203 15.2109 4.10685C15.1532 4.02417 15.0603 3.91811 14.9776 3.82849L14.6617 3.49782C13.5746 2.39643 11.221 0.851526 10.001 0.339637C10.001 0.328621 9.2428 0.0119332 8.8819 0H8.83372C8.28009 0 7.76282 0.31577 7.49828 0.826143C7.42601 0.965669 7.35669 1.23898 7.30396 1.47903L7.20919 1.93226C7.10101 2.6611 7.02919 3.77914 7.02919 5.00551ZM1.75271 3.73472C1.0609 3.73472 0.5 4.30108 0.5 4.99963C0.5 5.69818 1.0609 6.26455 1.75271 6.26455L4.8354 5.99192C5.37812 5.99192 5.81812 5.54856 5.81812 4.99963C5.81812 4.45162 5.37812 4.00734 4.8354 4.00734L1.75271 3.73472Z" fill="#547b53"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            new Swiper('#gall_slider_home', {
                slidesPerView: 3,
                spaceBetween: 20,
                navigation: {
                    nextEl: '#arrow_holder_home .nav__next',
                    prevEl: '#arrow_holder_home .nav__prev',
                },
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                },
            });
        });
    </script>
@endpush
