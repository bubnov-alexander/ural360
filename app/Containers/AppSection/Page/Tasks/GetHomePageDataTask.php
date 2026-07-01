<?php

namespace App\Containers\AppSection\Page\Tasks;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GetHomePageDataTask extends ParentTask
{
    private const string IMPORTED_UPLOADS_PATH = 'legacy-theme/assets/images/imported/wp-content/uploads';

    public function __construct(
        private readonly ContactSettings $contactSettings,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function run(): array
    {
        $homePage = Schema::hasTable('pages')
            ? Page::query()
                ->where('type', PageType::HOME)
                ->where('is_published', true)
                ->with('seo')
                ->orderBy('id')
                ->first()
            : null;

        return [
            'page' => $homePage,
            'settings' => $this->settings(),
            'navigation' => $this->navigation(),
            'hero' => $this->hero(),
            'advantages' => $this->advantages(),
            'services' => $this->services(),
            'tours' => $this->tours(),
            'about' => $this->about(),
            'gallery' => $this->gallery($homePage),
            'rental' => $this->rental(),
            'routesBackground' => asset(self::IMPORTED_UPLOADS_PATH . '/2025/04/routes-bg.jpg'),
        ];
    }

    /**
     * @return array<string, string|null>
     */
    private function settings(): array
    {
        return [
            'siteName' => $this->contactSettings->site_name,
            'phone' => $this->contactSettings->phone,
            'email' => $this->contactSettings->email,
            'address' => $this->contactSettings->address,
            'logo' => asset(self::IMPORTED_UPLOADS_PATH . '/2025/04/avatar-header.png'),
            'footerLogo' => asset(self::IMPORTED_UPLOADS_PATH . '/2025/04/avatar-footer.png'),
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
                'label' => 'Популярные маршруты',
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
        if (!Schema::hasTable('services')) {
            return [];
        }

        return Service::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get()
            ->map(fn (Service $service): array => [
                'label' => $service->getAttribute('title'),
                'url' => '/service/' . $service->getAttribute('slug') . '/',
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function tourNavigationItems(): array
    {
        if (!Schema::hasTable('tours')) {
            return [];
        }

        return Tour::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get()
            ->map(fn (Tour $tour): array => [
                'label' => $tour->getAttribute('title'),
                'url' => '/routes/' . $tour->getAttribute('slug') . '/',
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function hero(): array
    {
        return [
            'title' => 'Сплав по Чусовой',
            'description' => 'предоставляем услуги:',
            'backgroundImage' => asset(self::IMPORTED_UPLOADS_PATH . '/2025/04/home-hero.png'),
            'image' => null,
            'features' => [
                'Сплавы для детей и взрослых',
                'Адреналин на каждом повороте',
                'Корпоративный сплав для коллег и друзей',
            ],
            'params' => [
                'ПРОКАТ КАТАМАРАНОВ',
                'ПРОКАТ САП-БОРДОВ',
                'ТРАНСПОРТНЫЕ УСЛУГИ',
                'АВТОСТОЯНКА',
            ],
        ];
    }

    /**
     * @return array<int, array{title: string, icon: string}>
     */
    private function advantages(): array
    {
        return [
            [
                'title' => 'Сервис №1 на Чусовой в сфере услуг',
                'icon' => asset('legacy-theme/assets/images/advantage-like.svg'),
            ],
            [
                'title' => 'Оперативность оформления и выдачи',
                'icon' => asset('legacy-theme/assets/images/advantage-bell.svg'),
            ],
            [
                'title' => 'Сотрудничество с организациями',
                'icon' => asset('legacy-theme/assets/images/advantage-check.svg'),
            ],
        ];
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    private function services(): array
    {
        $sortOrder = [
            'Прокат катамаранов' => 0,
            'Прокат SUP-бордов' => 1,
            'Трансфер' => 2,
            'Автостоянка' => 3,
        ];

        if (!Schema::hasTable('services')) {
            return [];
        }

        return Service::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get()
            ->sortBy(fn (Service $service): int => $sortOrder[$service->getAttribute('title')] ?? 100)
            ->take(4)
            ->map(function (Service $service): array {
                $media = $service->getFirstMedia(Service::MEDIA_COLLECTION_SERVICE_IMAGE);
                $title = $service->getAttribute('title');

                return [
                    'title' => $title,
                    'url' => '/service/' . $service->getAttribute('slug') . '/',
                    'description' => $this->excerpt($service->getAttribute('content')),
                    'image' => $this->firstMediaWebpUrl($media),
                    'imageAlt' => $this->mediaAlt($media, $title),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    private function tours(): array
    {
        $sortOrder = [
            'Сплав по Чусовой: Усть-Утка - Ёква, 24 км' => 0,
            'Сплав по Чусовой: Сулём - Ёква, 40 км' => 1,
            'Маршрут Усть-Утка - Верхняя Ослянка, 86 км' => 2,
            'Маршрут «Индивидуальный»' => 3,
        ];

        if (!Schema::hasTable('tours')) {
            return [];
        }

        return Tour::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get()
            ->sortBy(fn (Tour $tour): int => $sortOrder[$tour->getAttribute('title')] ?? 100)
            ->take(4)
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
     * @return array<string, mixed>
     */
    private function about(): array
    {
        return [
            'title' => 'О компании',
            'description' => "Ural 360° - организует ваш идеальный сплав по реке Чусовая!\n\nМы уже более 5 лет предоставляем качественные услуги в области проката Катамаранов, SUP-бордов, Трансфера и Автостоянки, став лидерами в данной сфере. Наша команда заботится о том, чтобы вы удобно провели отдых в кругу семьи, друзей или корпоративом, находясь своей компанией и обеспечивая бюджетный подход.\n\nЕжегодно свыше 1000 туристов обращаются к нам для незабываемого сплава на наших комфортабельных катамаранах. Мы гордимся высоким уровнем безопасности и комфорта, а также индивидуальным подходом к каждому клиенту.\n\nНаша миссия - вдохновлять людей на активный отдых, позволяя насладиться красотой уральских пейзажей без переплат.\n\nМы гарантируем высокий уровень сервиса, чтобы каждая поездка стала не просто путешествием, а значимым событием в жизни. Ural 360° - это возможность открыть новые горизонты и создать яркие воспоминания с близкими.",
            'stats' => [
                ['value' => '7+', 'label' => 'квалифицированных специалистов'],
                ['value' => '5+', 'label' => 'лет опыта работы'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function gallery(?Page $homePage): array
    {
        $images = $homePage?->getMedia(Page::MEDIA_COLLECTION_HOME_GALLERY)
            ->map(fn (Media $media): array => [
                'url' => $this->firstMediaWebpUrl($media) ?? $media->getUrl(),
                'alt' => $this->mediaAlt($media),
            ])
            ->values()
            ->all() ?? [];

        return [
            'title' => 'Фотогалерея',
            'images' => $images,
        ];
    }

    /**
     * @return array<string, string|null>
     */
    private function rental(): array
    {
        return [
            'title' => 'Аренда катамаранов',
            'image' => null,
            'text' => 'Погрузитесь в мир водных приключений с нашей услугой аренды катамаранов. Мы предлагаем современные катамараны для семейного отдыха, встреч с друзьями и спокойных прогулок по Чусовой. Команда поможет с подготовкой, выдачей и организацией безопасного отдыха.',
        ];
    }

    private function excerpt(?string $content): string
    {
        $text = trim((string)preg_replace('/\s+/', ' ', strip_tags((string)$content)));

        return Str::limit($text, 150);
    }

    private function tourDescription(Tour $tour): string
    {
        return $this->tourDescriptionByTitle($tour->getAttribute('title'));
    }

    private function tourDescriptionByTitle(string $title): string
    {
        return match ($title) {
            'Сплав по Чусовой: Усть-Утка - Ёква, 24 км' => '<p><strong>Усть-Утка - Ёква<br></strong>≈ продолжительность: 1-3 дня<strong><br></strong></p><p><strong>В стоимость входит:</strong></p><ul><li>6-8 местный катамаран в сборе (баллоны, рама, твердая палуба), жилеты, весла, насос.</li><li>Сборка и доставка катамаранов в обе стороны</li><li>Довезем вашего водителя до катамарана</li></ul>',
            'Сплав по Чусовой: Сулём - Ёква, 40 км' => '<p><strong>Сулём - Ёква<br></strong>≈ продолжительность: 2-4 дня<strong><br></strong></p><p><strong>В стоимость входит:</strong></p><ul><li>6-8 местный катамаран в сборе (баллоны, рама, твердая палуба), жилеты, весла, насос.</li><li>Сборка и доставка катамаранов в обе стороны</li><li>Довезем вашего водителя до катамарана</li></ul>',
            'Маршрут Усть-Утка - Верхняя Ослянка, 86 км' => '<p><strong>Усть-Утка - Верхняя Ослянка<br></strong>≈ продолжительность: 5-7 дней<strong><br></strong></p><p><strong>В стоимость входит:</strong></p><ul><li>6-8 местный катамаран в сборе (баллоны, рама, твердая палуба), жилеты, весла, рем.набор, насос.</li><li>Сборка и доставка катамаранов в обе стороны</li><li>Довезем вашего водителя до катамарана</li></ul>',
            'Маршрут «Индивидуальный»' => '<p><strong>Организуем маршрут по Вашим пожеланиям</strong></p><p><strong>В стоимость входит:</strong></p><ul><li>6-8 местный катамаран в сборе (баллоны, рама, твердая палуба), жилеты, весла, рем.набор, насос.</li><li>Сборка и доставка катамаранов в обе стороны</li><li>Довезем вашего водителя до катамарана</li></ul>',
            default => '<p></p>',
        };
    }

    private function assetPreferWebp(string $path): string
    {
        $webpPath = preg_replace('/\.(png|jpe?g)$/i', '.webp', $path);

        if ($webpPath !== null && $webpPath !== $path && is_file(public_path($webpPath))) {
            return asset($webpPath);
        }

        return asset($path);
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

    private function mediaAlt(?Media $media, string $fallback = 'Фотография сплава по Чусовой'): string
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
