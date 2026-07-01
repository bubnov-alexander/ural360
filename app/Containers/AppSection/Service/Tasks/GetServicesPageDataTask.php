<?php

namespace App\Containers\AppSection\Service\Tasks;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GetServicesPageDataTask extends ParentTask
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
        $page = Schema::hasTable('pages')
            ? Page::query()
                ->where('type', PageType::SERVICES)
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
        return $this->services()
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
     * @return Collection<int, array{title: string, url: string, image: string|null, imageAlt: string}>
     */
    private function services(): Collection
    {
        if (!Schema::hasTable('services')) {
            return collect();
        }

        return Service::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get()
            ->map(function (Service $service): array {
                $media = $service->getFirstMedia(Service::MEDIA_COLLECTION_SERVICE_IMAGE);
                $title = $service->getAttribute('title');

                return [
                    'title' => $title,
                    'url' => '/service/' . $service->getAttribute('slug') . '/',
                    'image' => $this->firstMediaWebpUrl($media),
                    'imageAlt' => $this->mediaAlt($media, $title),
                ];
            })
            ->values();
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
