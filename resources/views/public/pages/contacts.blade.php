@extends('public.layout')

@section('body_class', 'page page-template-default')
@section('main_class', 'site-main')

@section('content')
    <section id="contacts-block" class="contacts-page">
        <div class="container">
            <h1 class="page-title">{{ $title }}</h1>

            <div class="contacts">
                <div class="contacts__wrap">
                    @if(!empty($contacts['address']))
                        <div class="item-wrap address">
                            <div class="title">
                                <img src="{{ asset('legacy-theme/assets/images/map.svg') }}" alt="">
                                Адрес
                            </div>
                            <div class="item">{{ $contacts['address'] }}</div>
                        </div>
                    @endif

                    @if(!empty($contacts['phone']))
                        <div class="item-wrap phone">
                            <div class="title">
                                <img src="{{ asset('legacy-theme/assets/images/phone.svg') }}" alt="">
                                Телефон
                            </div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contacts['phone']) }}" class="item">{{ $contacts['phone'] }}</a>
                        </div>
                    @endif

                    @if(!empty($contacts['email']))
                        <div class="item-wrap email">
                            <div class="title">
                                <img src="{{ asset('legacy-theme/assets/images/mail.svg') }}" alt="">
                                Эл. почта
                            </div>
                            <a href="mailto:{{ $contacts['email'] }}" class="item">{{ $contacts['email'] }}</a>
                        </div>
                    @endif

                    @if(!empty($contacts['socials']))
                        <div class="soc">
                            @foreach($contacts['socials'] as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="nofollow noopener" class="soc__item" aria-label="{{ $social['label'] }}">
                                    @if(!empty($social['icon']))
                                        <img src="{{ $social['icon'] }}" width="24" height="24" alt="">
                                    @else
                                        <span>{{ $social['label'] }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="contacts__map">
                    <div class="map-holder">
                        @if(!empty($contacts['mapScript']))
                            {!! $contacts['mapScript'] !!}
                        @else
                            <div class="contacts-page__map-empty">Карта скоро появится.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
