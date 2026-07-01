<?php

namespace App\Containers\AppSection\Tour\Tasks;

use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GetTourPageDataTask extends ParentTask
{
    public function __construct(
        private readonly ContactSettings $contactSettings,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function run(string $slug): array
    {
        $tour = Tour::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with('seo')
            ->firstOrFail();

        $tourImage = $tour->getFirstMedia(Tour::MEDIA_COLLECTION_TOUR_IMAGE);

        return [
            'page' => $tour,
            'tour' => $tour,
            'tourImage' => $this->firstMediaWebpUrl($tourImage),
            'tourImageAlt' => $this->mediaAlt($tourImage, $tour->getAttribute('title')),
            'routeLength' => $tour->getAttribute('route_length') !== null
                ? $tour->getAttribute('route_length') . ' км'
                : 'индивидуально',
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
