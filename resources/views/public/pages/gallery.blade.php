@extends('public.layout')

@section('body_class', 'archive post-type-archive-gallery')
@section('main_class', 'archive')

@section('content')
    <section id="gallery-archive" class="site-page">
        <div class="container">
            <h1 class="page-title">{{ $title }}</h1>

            @if(!empty($images))
                <div class="gallery gallery-archive__grid">
                    @foreach($images as $image)
                        <a href="{{ $image['url'] }}" class="item" data-fancybox="gallery-page">
                            <div class="item__img">
                                <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}">
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="content block-text">
                    <p>Фотографии скоро появятся.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
