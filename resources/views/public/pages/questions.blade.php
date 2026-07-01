@extends('public.layout')

@section('body_class', 'archive post-type-archive-questions')
@section('main_class', 'archive')

@section('content')
    <section id="question-archive" class="archive">
        <div class="container">
            <h1 class="page-title">{{ $title }}</h1>
            <div class="question">
                <div class="question__accordeon">
                    @if(!empty($questions))
                        <div class="tabs-grid flex">
                            <div class="acc__block">
                                @foreach($questions as $item)
                                    <div class="accordeon">
                                        <div class="accordeon__title @if($loop->first) is-opened @endif">
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
                    @else
                        <div class="content block-text">
                            <p>Вопросы скоро появятся.</p>
                        </div>
                    @endif
                </div>
                <div class="question__form">
                    <div class="form">
                        <h3 class="form__title">Оставить заявку</h3>
                        <button class="btn form__btn open-modal" data-modal="questions" type="button">Оставить заявку</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
