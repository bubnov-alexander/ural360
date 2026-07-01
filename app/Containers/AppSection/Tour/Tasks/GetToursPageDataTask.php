<?php

namespace App\Containers\AppSection\Tour\Tasks;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Containers\AppSection\Faq\Models\Faq;
use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GetToursPageDataTask extends ParentTask
{
    public function __construct(
        private readonly ContactSettings $contactSettings,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function run(): array
    {
        $page = Schema::hasTable('pages')
            ? Page::query()
                ->where('type', PageType::ROUTES)
                ->where('is_published', true)
                ->with('seo')
                ->orderBy('id')
                ->first()
            : null;

        return [
            'page' => $page,
            'settings' => $this->settings(),
            'navigation' => $this->navigation(),
            'services' => $this->services(),
            'tours' => $this->tours(),
            'shopHero' => $this->shopHero(),
            'paydel' => $this->paydel(),
            'about' => $this->about(),
            'faq' => $this->faq(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function settings(): array
    {
        return [
            'siteName' => $this->contactSettings->site_name,
            'phone' => $this->contactSettings->phone,
            'email' => $this->contactSettings->email,
            'address' => $this->contactSettings->address,
            'logo' => '/legacy-theme/assets/images/shop-page/logo-header.png',
            'footerLogo' => '/legacy-theme/assets/images/shop-page/logo-footer.png',
            'headerBackground' => '',
            'phoneIcon' => asset('legacy-theme/assets/images/phone.svg'),
            'emailIcon' => asset('legacy-theme/assets/images/mail.svg'),
            'avitoTitle' => null,
            'avitoRating' => null,
            'avitoIcon' => null,
            'avitoUrl' => null,
            'maxUrl' => $this->contactSettings->max_url,
            'whatsappUrl' => $this->contactSettings->whatsapp_url,
            'telegramUrl' => $this->contactSettings->telegram_url,
            'vkUrl' => $this->contactSettings->vk_url,
            'socials' => [],
        ];
    }

    /**
     * @return array<int, array{label: string, url: string, children: array<int, array{label: string, url: string}>}>
     */
    private function navigation(): array
    {
        return [
            [
                'label' => 'Услуги',
                'url' => '/service/',
                'children' => $this->serviceNavigationItems(),
            ],
            [
                'label' => 'Маршруты',
                'url' => '/routes/',
                'children' => $this->tourNavigationItems(),
            ],
            ['label' => 'О компании', 'url' => '/about/', 'children' => []],
            ['label' => 'Фотогалерея', 'url' => '/gallery/', 'children' => []],
            ['label' => 'Вопрос - ответ', 'url' => '/questions/', 'children' => []],
            ['label' => 'Контакты', 'url' => '/contacts/', 'children' => []],
        ];
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function serviceNavigationItems(): array
    {
        return collect($this->services())
            ->map(fn (array $service): array => [
                'label' => $service['title'],
                'url' => $service['url'],
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function tourNavigationItems(): array
    {
        return collect($this->tours())
            ->map(fn (array $tour): array => [
                'label' => $tour['title'],
                'url' => $tour['url'],
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{title: string, url: string}>
     */
    private function services(): array
    {
        if (! Schema::hasTable('services')) {
            return [];
        }

        return Service::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get()
            ->map(fn (Service $service): array => [
                'title' => $service->getAttribute('title'),
                'url' => '/service/' . $service->getAttribute('slug') . '/',
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{title: string, url: string, description: string, routeLength: string, image: string|null, imageAlt: string}>
     */
    private function tours(): array
    {
        if (! Schema::hasTable('tours')) {
            return [];
        }

        return Tour::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get()
            ->map(function (Tour $tour): array {
                $media = $tour->getFirstMedia(Tour::MEDIA_COLLECTION_TOUR_IMAGE);
                $title = $tour->getAttribute('title');

                return [
                    'title' => $title,
                    'url' => '/routes/' . $tour->getAttribute('slug') . '/',
                    'description' => $this->tourDescription($tour),
                    'routeLength' => $tour->getAttribute('route_length') !== null
                        ? $tour->getAttribute('route_length') . ' км'
                        : 'индивидуально',
                    'image' => $this->firstMediaWebpUrl($media),
                    'imageAlt' => $this->mediaAlt($media, $title),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<string, string>
     */
    private function shopHero(): array
    {
        return [
            'title' => 'Возьмите катамаран в аренду от 1 дня',
            'description' => "- В наличии различные модели катамаранов, подходящие для разных групп людей<br>\n- Предоставляется краткий инструктаж по управлению катамараном <br>\n- Возможность заказа трансфера и аренды дополнительного оборудования",
            'button' => 'Оставить заявку',
            'backgroundImage' => '/legacy-theme/assets/images/shop-page/image-3449-5-1.png',
            'image' => '/legacy-theme/assets/images/shop-page/betta-1-1200x800-1.png',
        ];
    }

    /**
     * @return array<int, array{title: string, description: string, image: string}>
     */
    private function paydel(): array
    {
        return [
            [
                'title' => 'Оплата',
                'description' => "Мы предлагаем удобные и безопасные способы оплаты для аренды катамаранов и САП-бордов. Вы можете выбрать наиболее подходящий вариант для вас:<br><br>Онлайн-оплата: Удобный способ оплаты через наш сайт с использованием банковских карт. Мы принимаем карты Visa, MasterCard и другие популярные платежные системы<br><br>Наличный расчет: Вы можете оплатить аренду наличными при получении катамарана или САП-борда. Пожалуйста, убедитесь, что у вас есть необходимая сумма<br><br>Предоплата: Для бронирования катамарана или САП-борда может потребоваться предоплата. Сумма предоплаты будет указана при оформлении заказа<br><br>Чек и квитанция: После оплаты вы получите чек или квитанцию, подтверждающую вашу аренду",
                'image' => '/legacy-theme/assets/images/shop-page/icons8-money.png',
            ],
            [
                'title' => 'Доставка',
                'description' => "Мы предлагаем удобные услуги доставки для арендуемых катамаранов и САП-бордов, чтобы сделать ваш отдых максимально комфортным.<br><br>Условия доставки:<br><br>Доставка на место старта: Мы можем доставить ваше оборудование в заранее согласованное место на реке Чусовой. Укажите адрес при оформлении заказа, и мы позаботимся о доставке<br><br>Время доставки: Доставка осуществляется в удобное для вас время. Пожалуйста, сообщите нам о предпочтительном времени при бронировании<br><br>Самовывоз: Если вы предпочитаете забрать катамаран или САП-борд самостоятельно, вы можете сделать это по адресу нашего проката",
                'image' => '/legacy-theme/assets/images/shop-page/icons8-delivery.png',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function about(): array
    {
        return [
            'title' => 'О компании',
            'description' => 'Ural 360° — организует ваш идеальный сплав по реке Чусовая! Мы уже более 5 лет предоставляем качественные услуги в области проката катамаранов, трансфера и автостоянки, и за это время зарекомендовали себя как лидеры в данной сфере. Наша команда профессионалов заботится о каждом аспекте вашего путешествия, чтобы вы могли насладиться незабываемыми впечатлениями и красотой природы.',
            'stats' => [
                ['value' => '7+', 'label' => 'квалифицированных специалистов'],
                ['value' => '5+', 'label' => 'лет опыта работы'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function faq(): array
    {
        if (! Schema::hasTable('faqs') || ! Schema::hasTable('faq_questions')) {
            return [
                'title' => 'Вопрос – ответ',
                'items' => [],
            ];
        }

        $faq = Faq::query()
            ->where('is_published', true)
            ->with([
                'questions' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('id'),
            ])
            ->orderBy('id')
            ->first();

        if ($faq === null) {
            return [
                'title' => 'Вопрос – ответ',
                'items' => [],
            ];
        }

        return [
            'title' => $faq->getAttribute('title'),
            'items' => $faq->questions
                ->map(fn ($question): array => [
                    'question' => $question->getAttribute('question'),
                    'answer' => $question->getAttribute('answer'),
                ])
                ->values()
                ->all(),
        ];
    }

    private function tourDescription(Tour $tour): string
    {
        $text = trim((string)preg_replace('/\s+/', ' ', strip_tags((string)$tour->getAttribute('content'))));

        return Str::limit($text, 220);
    }

    private function firstMediaWebpUrl(?Media $media): ?string
    {
        if ($media === null) {
            return null;
        }

        if ($media->hasGeneratedConversion('webp')) {
            return $media->getUrl('webp');
        }

        return $media->getUrl();
    }

    private function mediaAlt(?Media $media, string $fallback): string
    {
        if ($media === null) {
            return $fallback;
        }

        $alt = trim((string)$media->getCustomProperty('alt'));

        if ($alt !== '') {
            return $alt;
        }

        return $media->getAttribute('name') ?: $fallback;
    }
}
