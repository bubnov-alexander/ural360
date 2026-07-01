@extends('public.layout')

@section('body_class', 'archive post-type-archive-product')
@section('main_class', 'archive-page')

@section('content')
    <div id="routes-archive" class="catalog site-page">
        <div class="container">
            <h1 class="page-title">{{ $page?->getAttribute('title') ?? 'Популярные маршруты' }}</h1>

            <div class="catalog__products routes-archive__products">
                <div class="catalog__holder routes-archive__holder">
                    @if(!empty($tours))
                        <ul class="products columns-3 routes-archive__grid">
                            @foreach($tours as $tour)
                                <li class="product type-product">
                                    <a href="{{ $tour['url'] }}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                        @if(!empty($tour['image']))
                                            <div class="product-image">
                                                <img src="{{ $tour['image'] }}" alt="{{ $tour['imageAlt'] }}">
                                            </div>
                                        @endif

                                        <h2 class="woocommerce-loop-product__title">{{ $tour['title'] }}</h2>

                                        <div class="product-attrs">
                                            <div class="item">
                                                <span class="item__title">Протяженность</span>
                                                <span class="item__value">{{ $tour['routeLength'] }}</span>
                                            </div>
                                        </div>

                                        <div class="product-wrap">
                                            <div class="product_desc">{{ $tour['description'] }}</div>
                                            <span class="btn">Забронировать</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="hero-block" class="alignfull routes-rental-hero">
        <div class="hero-image-bg">
            <img src="{{ $shopHero['backgroundImage'] }}" alt="">
        </div>
        <div class="container">
            <div class="hero">
                <div class="hero__content">
                    <h1 class="hero__title">{{ $shopHero['title'] }}</h1>
                    <p class="hero__desc">{!! $shopHero['description'] !!}</p>
                    <button class="btn open-modal" data-modal="callback" type="button">{{ $shopHero['button'] }}</button>
                </div>
                <div class="hero__image">
                    <img src="{{ $shopHero['image'] }}" alt="{{ $shopHero['title'] }}">
                </div>
            </div>
        </div>
    </div>

    <div class="paydel-block alignfull">
        <div class="container">
            <div class="paydel-block__wrapper">
                @foreach($paydel as $item)
                    <div class="paydel-block__item">
                        <div class="item__img-holder">
                            <img class="item__img" src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                        </div>
                        <div class="item__info">
                            <h3 class="item__title">{{ $item['title'] }}</h3>
                            <span class="item__desc">{!! $item['description'] !!}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="about-block" class="alignfull">
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
                    <p class="desc">{{ $about['description'] }}</p>
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

    <section class="faq alignwide">
        <div class="container">
            <h2 class="faq__title block-title">{{ $faq['title'] }}</h2>
            <div class="faq__row">
                <div class="faq__content">
                    <div class="tabs-grid flex">
                        <div class="acc__block">
                            @foreach($faq['items'] as $item)
                                <div class="accordeon">
                                    <div class="accordeon__title @if($loop->iteration === 2) is-opened @endif">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10.015C0 4.74712 4.21 0 10.02 0C15.7 0 20 4.65699 20 9.98498C20 16.1642 14.96 20 10 20C8.36 20 6.54 19.5593 5.08 18.698C4.57 18.3876 4.14 18.1572 3.59 18.3375L1.57 18.9384C1.06 19.0986 0.6 18.698 0.75 18.1572L1.42 15.9139C1.53 15.6034 1.51 15.2729 1.35 15.0125C0.49 13.4301 0 11.6975 0 10.015ZM8.7 10.015C8.7 10.7261 9.27 11.2969 9.98 11.307C10.69 11.307 11.26 10.7261 11.26 10.025C11.26 9.31397 10.69 8.74311 9.98 8.74311C9.28 8.7331 8.7 9.31397 8.7 10.015ZM13.3104 10.025C13.3104 10.7261 13.8804 11.307 14.5904 11.307C15.3004 11.307 15.8704 10.7261 15.8704 10.025C15.8704 9.31396 15.3004 8.74311 14.5904 8.74311C13.8804 8.74311 13.3104 9.31396 13.3104 10.025ZM5.37 11.307C4.67 11.307 4.09 10.7261 4.09 10.025C4.09 9.31397 4.66 8.74311 5.37 8.74311C6.08 8.74311 6.65 9.31397 6.65 10.025C6.65 10.7261 6.08 11.2969 5.37 11.307Z" fill="#F59D16"/>
                                        </svg>
                                        <div class="vopros">{{ $item['question'] }}</div>
                                        <div class="icon"></div>
                                    </div>
                                    <div class="accordeon__content">
                                        <div class="otvet">{{ $item['answer'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="faq__form">
                    <div class="form">
                        <h3 class="form__title">Оставить заявку</h3>
                        <button class="btn form__btn open-modal" data-modal="questions" type="button">Оставить заявку</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
