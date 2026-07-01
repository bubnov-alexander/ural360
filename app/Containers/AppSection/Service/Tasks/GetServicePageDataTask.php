<?php

namespace App\Containers\AppSection\Service\Tasks;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GetServicePageDataTask extends ParentTask
{
    private const string IMPORTED_UPLOADS_PATH = 'legacy-theme/assets/images/imported/wp-content/uploads';

    public function __construct(
        private readonly ContactSettings $contactSettings,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function run(string $slug): array
    {
        $service = Service::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with(['prices', 'seo'])
            ->firstOrFail();

        $serviceImage = $service->getFirstMedia(Service::MEDIA_COLLECTION_SERVICE_IMAGE);

        return [
            'page' => $service,
            'service' => $service,
            'serviceImage' => $this->firstMediaWebpUrl($serviceImage),
            'serviceImageAlt' => $this->mediaAlt($serviceImage, $service->getAttribute('title')),
            'serviceContent' => $this->contentWithoutFirstHeading($service),
            'servicePrices' => $this->servicePrices($service),
            'about' => $this->about(),
            'gallery' => $this->gallery(),
            'settings' => $this->settings(),
            'navigation' => $this->navigation(),
            'services' => $this->services(),
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
        if (! Schema::hasTable('tours')) {
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
     * @return array<string, mixed>
     */
    private function about(): array
    {
        return [
            'title' => 'О компании',
            'description' => "Ural 360° — организует ваш идеальный сплав по реке Чусовая!\n\nМы уже более 5 лет предоставляем качественные услуги в области проката катамаранов, трансфера и автостоянки, и за это время зарекомендовали себя как лидеры данной сферы. Наша команда профессионалов заботится о каждом аспекте вашего путешествия, чтобы вы могли насладиться незабываемыми впечатлениями и красотой природы.",
            'stats' => [
                ['value' => '7+', 'label' => 'квалифицированных специалистов'],
                ['value' => '5+', 'label' => 'лет опыта работы'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function gallery(): array
    {
        if (! Schema::hasTable('pages')) {
            return [
                'title' => 'Фотогалерея',
                'images' => [],
            ];
        }

        $homePage = Page::query()
            ->where('type', PageType::HOME)
            ->where('is_published', true)
            ->orderBy('id')
            ->first();

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

    private function contentWithoutFirstHeading(Service $service): string
    {
        $content = (string)$service->getAttribute('content');

        return (string)preg_replace('/^\\s*<h1[^>]*>.*?<\\/h1>\\s*/is', '', $content, 1);
    }

    /**
     * @return array<int, array{label: string, price: string}>
     */
    private function servicePrices(Service $service): array
    {
        return $service->prices
            ->map(fn ($price): array => [
                'label' => $price->getAttribute('label'),
                'price' => $price->getAttribute('price'),
            ])
            ->values()
            ->all();
    }
}
