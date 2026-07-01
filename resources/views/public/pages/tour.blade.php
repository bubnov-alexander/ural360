@extends('public.layout')

@section('body_class', 'single single-product')
@section('main_class', 'single__product site-page')

@section('content')
    <div id="tour-page" class="container">
        <div class="product type-product">
            <div class="product__title">
                <h1 class="page-title">{{ $tour->getAttribute('title') }}</h1>
            </div>

            <div class="wrap">
                <div class="product__gallery">
                    @if(!empty($tourImage))
                        <div class="woocommerce-product-gallery images">
                            <figure class="woocommerce-product-gallery__wrapper">
                                <div class="product__gallery-swiper">
                                    <a class="image" data-fancybox="gallery-prodyct" href="{{ $tourImage }}">
                                        <img src="{{ $tourImage }}" alt="{{ $tourImageAlt }}">
                                    </a>
                                </div>
                            </figure>
                        </div>
                    @endif
                </div>

                <div class="product__content">
                    <div class="tour-detail__attrs attrs">
                        @if($tour->getAttribute('start_location') !== null)
                            <div class="tour-detail__attr">
                                <span>Старт</span>
                                <strong>{{ $tour->getAttribute('start_location') }}</strong>
                            </div>
                        @endif

                        @if($tour->getAttribute('finish_location') !== null)
                            <div class="tour-detail__attr">
                                <span>Финиш</span>
                                <strong>{{ $tour->getAttribute('finish_location') }}</strong>
                            </div>
                        @endif

                        <div class="tour-detail__attr">
                            <span>Протяженность</span>
                            <strong>{{ $routeLength }}</strong>
                        </div>
                    </div>

                    <div class="woocommerce-product-details__short-description tour-detail__content">
                        {!! $tour->getAttribute('content') !!}
                    </div>

                    <div class="product-wrap">
                        <button class="btn open-modal" data-modal="callback" type="button">Забронировать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
