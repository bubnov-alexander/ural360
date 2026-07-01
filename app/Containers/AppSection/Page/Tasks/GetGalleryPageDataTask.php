<?php

namespace App\Containers\AppSection\Page\Tasks;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GetGalleryPageDataTask extends ParentTask
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
        $page = Page::query()
            ->where('title', 'Фотогалерея')
            ->where('is_published', true)
            ->with('seo')
            ->first();

        $homePage = Page::query()
            ->where('type', PageType::HOME)
            ->where('is_published', true)
            ->orderBy('id')
            ->first();

        return [
            'page' => $page,
            'title' => $page?->getAttribute('title') ?? 'Фотогалерея',
            'images' => $this->images($homePage),
            'settings' => $this->settings(),
            'navigation' => $this->navigation(),
            'services' => $this->services(),
        ];
    }

    /**
     * @return array<int, array{url: string, alt: string}>
     */
    private function images(?Page $homePage): array
    {
        return $homePage?->getMedia(Page::MEDIA_COLLECTION_HOME_GALLERY)
            ->filter(fn (Media $media): bool => $media->hasGeneratedConversion('webp'))
            ->map(fn (Media $media): array => [
                'url' => $media->getUrl('webp'),
                'alt' => $this->mediaAlt($media),
            ])
            ->values()
            ->all() ?? [];
    }

    private function mediaAlt(Media $media): string
    {
        $alt = trim((string)$media->getCustomProperty('alt'));

        if ($alt !== '') {
            return $alt;
        }

        return $media->getAttribute('name') ?: 'Фотография сплава по Чусовой';
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

}
