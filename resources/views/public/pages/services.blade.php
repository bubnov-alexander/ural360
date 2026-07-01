@extends('public.layout')

@section('body_class', 'archive post-type-archive-service')
@section('main_class', 'archive-page')

@section('content')
    <div id="service-archive" class="archive">
        <div class="container">
            <h1 class="page-title">{{ $page?->getAttribute('title') ?? 'Услуги' }}</h1>

            @if($services->isNotEmpty())
                <div class="service">
                    @foreach($services as $service)
                        <a href="{{ $service['url'] }}" class="item">
                            <div class="item__wrap">
                                <h3 class="item__name">{{ $service['title'] }}</h3>
                                <button class="item__btn btn__link" type="button">Узнать подробнее</button>
                            </div>
                            @if(!empty($service['image']))
                                <div class="item__image">
                                    <img src="{{ $service['image'] }}" alt="{{ $service['imageAlt'] }}">
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
