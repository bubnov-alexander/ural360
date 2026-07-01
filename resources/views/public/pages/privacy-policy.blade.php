@extends('public.layout')

@section('body_class', 'page page-template-default privacy-policy')
@section('main_class', 'site-main')

@section('content')
    <article id="privacy-policy-page" class="site-page content-page">
        <div class="container">
            <h1 class="page-title">{{ $page->getAttribute('title') }}</h1>
            <div class="content block-text content-page__body">
                {!! $page->getAttribute('content') !!}
            </div>
        </div>
    </article>
@endsection
