<header id="header" class="header" style="background-image: url('{{ $settings['headerBackground'] ?? '' }}');">
    <div class="container">
        <div class="header__main">
            <div class="header__main-left">
                @if($settings['logo'])
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ $settings['logo'] }}" alt="{{ $settings['siteName'] }}" class="logo">
                    </a>
                @endif

                @if(!empty($settings['avitoRating']))
                    <a @if(!empty($settings['avitoUrl'])) href="{{ $settings['avitoUrl'] }}" target="_blank" @endif class="avito_rewiews">
                        @if(!empty($settings['avitoTitle']))
                            <p class="p3">{{ $settings['avitoTitle'] }}</p>
                        @endif
                        <div class="avito_rewiews_bottom">
                            @if(!empty($settings['avitoIcon']))
                                <img src="{{ $settings['avitoIcon'] }}" alt="" class="avito_icon">
                            @endif
                            <p class="h6">{{ $settings['avitoRating'] }}</p>
                            <svg width="93" height="16" viewBox="0 0 93 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.36064 15.9392C3.97464 16.1504 3.53665 15.7803 3.61465 15.3078L4.44464 10.2626L0.921653 6.68298C0.592654 6.34806 0.763653 5.73581 1.20465 5.66968L6.10264 4.9273L8.28663 0.31199C8.48363 -0.103997 9.01663 -0.103997 9.21363 0.31199L11.3976 4.9273L16.2956 5.66968C16.7366 5.73581 16.9076 6.34806 16.5776 6.68298L13.0556 10.2626L13.8856 15.3078C13.9636 15.7803 13.5256 16.1504 13.1396 15.9392L8.74863 13.5329L4.35964 15.9392H4.36064Z" fill="#F8BF3A" />
                                <path d="M23.3606 15.9392C22.9746 16.1504 22.5366 15.7803 22.6146 15.3078L23.4446 10.2626L19.9217 6.68298C19.5927 6.34806 19.7637 5.73581 20.2047 5.66968L25.1026 4.9273L27.2866 0.31199C27.4836 -0.103997 28.0166 -0.103997 28.2136 0.31199L30.3976 4.9273L35.2956 5.66968C35.7366 5.73581 35.9076 6.34806 35.5776 6.68298L32.0556 10.2626L32.8856 15.3078C32.9636 15.7803 32.5256 16.1504 32.1396 15.9392L27.7486 13.5329L23.3596 15.9392H23.3606Z" fill="#F8BF3A" />
                                <path d="M42.3606 15.9392C41.9746 16.1504 41.5366 15.7803 41.6146 15.3078L42.4446 10.2626L38.9217 6.68298C38.5927 6.34806 38.7637 5.73581 39.2047 5.66968L44.1026 4.9273L46.2866 0.31199C46.4836 -0.103997 47.0166 -0.103997 47.2136 0.31199L49.3976 4.9273L54.2956 5.66968C54.7366 5.73581 54.9076 6.34806 54.5776 6.68298L51.0556 10.2626L51.8856 15.3078C51.9636 15.7803 51.5256 16.1504 51.1396 15.9392L46.7486 13.5329L42.3596 15.9392H42.3606Z" fill="#F8BF3A" />
                                <path d="M61.3606 15.9392C60.9746 16.1504 60.5366 15.7803 60.6146 15.3078L61.4446 10.2626L57.9217 6.68298C57.5927 6.34806 57.7637 5.73581 58.2047 5.66968L63.1026 4.9273L65.2866 0.31199C65.4836 -0.103997 66.0166 -0.103997 66.2136 0.31199L68.3976 4.9273L73.2956 5.66968C73.7366 5.73581 73.9076 6.34806 73.5776 6.68298L70.0556 10.2626L70.8856 15.3078C70.9636 15.7803 70.5256 16.1504 70.1396 15.9392L65.7486 13.5329L61.3596 15.9392H61.3606Z" fill="#F8BF3A" />
                                <path d="M80.3606 15.9392C79.9746 16.1504 79.5366 15.7803 79.6146 15.3078L80.4446 10.2626L76.9217 6.68298C76.5927 6.34806 76.7637 5.73581 77.2047 5.66968L82.1026 4.9273L84.2866 0.31199C84.4836 -0.103997 85.0166 -0.103997 85.2136 0.31199L87.3976 4.9273L92.2956 5.66968C92.7366 5.73581 92.9076 6.34806 92.5776 6.68298L89.0556 10.2626L89.8856 15.3078C89.9636 15.7803 89.5256 16.1504 89.1396 15.9392L84.7486 13.5329L80.3596 15.9392H80.3606Z" fill="#F8BF3A" />
                            </svg>
                        </div>
                    </a>
                @endif
            </div>
            <div class="item_flex">
                <div class="item phone">
                    @if($settings['phoneIcon'])
                        <div class="item__icon">
                            <img src="{{ $settings['phoneIcon'] }}" width="24" height="24" alt="">
                        </div>
                    @endif
                    <div class="item__wrap">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['phone']) }}" class="item__link">{{ $settings['phone'] }}</a>
                        <span class="item__title">Телефон</span>
                    </div>
                </div>
                <div class="item email">
                    @if($settings['emailIcon'])
                        <div class="item__icon">
                            <img src="{{ $settings['emailIcon'] }}" width="24" height="24" alt="">
                        </div>
                    @endif
                    <div class="item__wrap">
                        <a href="mailto:{{ $settings['email'] }}" class="item__link">{{ $settings['email'] }}</a>
                        <span class="item__title">Почта</span>
                    </div>
                </div>
            </div>
            <button class="btn header__btn open-modal" data-modal="callback">Оставить заявку</button>
            <div class="burger open_menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="header__navigation">
            <ul class="menu">
                @foreach($navigation as $item)
                    <li class="nav-menu-element @if(!empty($item['children'])) has-childs @endif">
                        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                        @if(!empty($item['children']))
                            <ul class="sub-menu">
                                @foreach($item['children'] as $child)
                                    <li class="nav-menu-element"><a href="{{ $child['url'] }}">{{ $child['label'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div id="mobile-mnu">
        <div id="close-mnu">
            <svg width="24px" height="24px" viewBox="0 0 225 225" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <g id="#ffffffff"></g>
                <g id="#000000ff">
                    <path fill="#4ca95b" opacity="1.00" d=" M 110.42 0.00 L 114.54 0.00 C 140.24 0.60 165.66 9.99 185.22 26.74 C 205.17 43.62 219.01 67.62 223.28 93.43 C 224.33 99.09 224.59 104.85 225.00 110.59 L 225.00 114.58 C 224.38 141.70 213.88 168.49 195.42 188.42 C 177.05 208.57 151.12 221.76 123.94 224.29 C 120.83 224.51 117.72 224.82 114.60 225.00 L 110.46 225.00 C 85.92 224.40 61.61 215.87 42.46 200.45 C 21.07 183.49 6.16 158.50 1.71 131.53 C 0.67 125.91 0.42 120.19 0.00 114.50 L 0.00 110.42 C 0.17 107.29 0.48 104.18 0.71 101.05 C 3.25 73.87 16.43 47.93 36.60 29.56 C 56.52 11.10 83.32 0.62 110.42 0.00 M 142.46 72.44 C 132.47 82.46 122.41 92.40 112.48 102.48 C 102.69 92.60 92.82 82.79 82.98 72.95 C 81.02 70.84 77.76 69.84 75.07 71.14 C 70.70 72.77 68.99 79.00 72.41 82.38 C 82.37 92.48 92.43 102.48 102.48 112.48 C 92.57 122.24 82.80 132.15 72.94 141.96 C 70.50 144.11 69.51 147.92 71.24 150.81 C 73.24 154.95 79.38 155.93 82.54 152.55 C 92.53 142.55 102.60 132.60 112.50 122.52 C 122.30 132.37 132.15 142.18 141.98 152.01 C 143.93 154.11 147.19 155.20 149.88 153.88 C 154.30 152.27 156.04 145.98 152.56 142.59 C 142.61 132.50 132.54 122.52 122.51 112.50 C 132.62 102.59 142.56 92.51 152.58 82.51 C 155.46 79.91 155.67 74.91 152.71 72.29 C 150.07 69.32 145.08 69.56 142.46 72.44 Z" />
                </g>
            </svg>
        </div>
        @if($settings['logo'])
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ $settings['logo'] }}" alt="" class="logo__icon">
            </a>
        @endif
        <ul class="menuTop">
            @foreach($navigation as $item)
                <li class="nav-menu-element @if(!empty($item['children'])) has-childs @endif">
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                    @if(!empty($item['children']))
                        <ul class="sub-menu">
                            @foreach($item['children'] as $child)
                                <li class="nav-menu-element"><a href="{{ $child['url'] }}">{{ $child['label'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="email">
            <span class="name-title">Почта</span>
            <a href="mailto:{{ $settings['email'] }}" class="email__item">{{ $settings['email'] }}</a>
        </div>
        <div class="phone">
            <span class="name-title">Телефон</span>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['phone']) }}" class="phone__item">{{ $settings['phone'] }}</a>
        </div>
    </div>
</header>
