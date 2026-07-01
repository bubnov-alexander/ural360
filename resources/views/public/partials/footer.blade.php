<footer id="footer" class="site-footer">
    <div class="container">
        <div class="grid">
            <div class="item">
                <h3 class="item__title">Меню</h3>
                <ul class="footer__menu">
                    <li class="nav-menu-element"><a href="/service/">Услуги</a></li>
                    <li class="nav-menu-element"><a href="/routes/">Маршруты</a></li>
                    <li class="nav-menu-element"><a href="/about/">О компании</a></li>
                    <li class="nav-menu-element"><a href="/questions/">Вопрос - ответ</a></li>
                    <li class="nav-menu-element"><a href="/contacts/">Контакты</a></li>
                </ul>
            </div>
            <div class="item">
                <h3 class="item__title">Услуги</h3>
                <ul class="footer__menu">
                    @foreach($services as $service)
                        <li class="nav-menu-element"><a href="{{ $service['url'] }}">{{ $service['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="item">
                <h3 class="item__title">Контакты</h3>
                <div class="contacts">
                    <div class="phone contacts__item">
                        @if($settings['phoneIcon'])
                            <div class="icon">
                                <img src="{{ $settings['phoneIcon'] }}" width="24" height="24" alt="">
                            </div>
                        @endif
                        <div class="wrap">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['phone']) }}" class="link">{{ $settings['phone'] }}</a>
                            <span class="name">Телефон</span>
                        </div>
                    </div>
                    <div class="email contacts__item">
                        @if($settings['emailIcon'])
                            <div class="icon">
                                <img src="{{ $settings['emailIcon'] }}" width="24" height="24" alt="">
                            </div>
                        @endif
                        <div class="wrap">
                            <a href="mailto:{{ $settings['email'] }}" class="link">{{ $settings['email'] }}</a>
                            <span class="name">Почта</span>
                        </div>
                    </div>
                    @php
                        $footerSocials = array_values(array_filter([
                            !empty($settings['maxUrl']) ? [
                                'label' => 'MAX',
                                'url' => $settings['maxUrl'],
                                'icon' => asset('legacy-theme/assets/images/max.svg'),
                            ] : null,
                            !empty($settings['whatsappUrl']) ? [
                                'label' => 'WhatsApp',
                                'url' => $settings['whatsappUrl'],
                                'icon' => asset('legacy-theme/assets/images/wp.svg'),
                            ] : null,
                            !empty($settings['telegramUrl']) ? [
                                'label' => 'Telegram',
                                'url' => $settings['telegramUrl'],
                                'icon' => asset('legacy-theme/assets/images/tg.svg'),
                            ] : null,
                            !empty($settings['vkUrl']) ? [
                                'label' => 'VK',
                                'url' => $settings['vkUrl'],
                                'icon' => asset('legacy-theme/assets/images/vk.svg'),
                            ] : null,
                        ]));
                    @endphp
                    @if(!empty($footerSocials))
                        <div class="soc">
                            @foreach($footerSocials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="nofollow noopener" class="soc__item" aria-label="{{ $social['label'] }}">
                                    <img src="{{ $social['icon'] }}" width="24" height="24" alt="">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="item logo-wrap">
                @if($settings['footerLogo'])
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ $settings['footerLogo'] }}" alt="{{ $settings['siteName'] }}" class="logo">
                    </a>
                @endif
                <div class="logo_text">Сплавы по Чусовой, прокат катамаранов, трансфер и автостоянка.</div>
            </div>
        </div>
    </div>
    <div class="grampus">
        <div class="container">
            <div class="grampus__wrap">
                <a href="/privacy-policy/" target="_blank" class="grampus__policy">Политика конфиденциальности</a>
                <p class="footer_text">© {{ date('Y') }} {{ $settings['siteName'] }}</p>
                <a class="grampus__link" href="https://grampus-studio.ru" target="_blank" rel="nofollow">Сайт разработан <span>GRAMPUS</span></a>
            </div>
        </div>
    </div>
    <div id="modal-callback" class="theme-modal">
        <div class="close-modal">&times;</div>
        <h2 class="title">Оставить заявку</h2>
        @include('public.partials.modal-form')
    </div>
    <div id="modal-order" class="theme-modal">
        <div class="close-modal">&times;</div>
        <h2 class="title">Оставить заявку</h2>
        @include('public.partials.modal-form')
    </div>
    <div id="modal-questions" class="theme-modal">
        <div class="close-modal">&times;</div>
        <h2 class="title">Оставить заявку</h2>
        @include('public.partials.modal-form')
    </div>
    <div id="modal-success" class="theme-modal">
        <div class="close-modal">&times;</div>
        <h2 class="title">Заявка успешно отправлена</h2>
        <p class="desc">Скоро мы свяжемся с Вами и уточним детали заказа</p>
        <a href="{{ route('home') }}" class="btn">На главную</a>
    </div>
    <div id="modal-error" class="theme-modal">
        <div class="close-modal">&times;</div>
        <div class="title">Ошибка!</div>
        <div class="subtitle">Во время отправки произошла ошибка, пожалуйста, попробуйте позже!</div>
    </div>
</footer>
