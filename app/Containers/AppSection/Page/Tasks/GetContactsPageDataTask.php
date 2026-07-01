<?php

namespace App\Containers\AppSection\Page\Tasks;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Facades\Schema;

final class GetContactsPageDataTask extends ParentTask
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
            ->where('type', PageType::CONTACTS)
            ->where('is_published', true)
            ->with('seo')
            ->first();

        return [
            'page' => $page,
            'title' => 'Контакты',
            'contacts' => $this->contacts(),
            'settings' => $this->settings(),
            'navigation' => $this->navigation(),
            'services' => $this->services(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function contacts(): array
    {
        return [
            'address' => $this->contactSettings->address,
            'phone' => $this->contactSettings->phone,
            'email' => $this->contactSettings->email,
            'mapScript' => $this->contactSettings->yandex_map_script,
            'socials' => array_values(array_filter([
                $this->contactSettings->max_url !== null ? [
                    'label' => 'MAX',
                    'url' => $this->contactSettings->max_url,
                    'icon' => asset('legacy-theme/assets/images/max.svg'),
                ] : null,
                $this->contactSettings->whatsapp_url !== null ? [
                    'label' => 'WhatsApp',
                    'url' => $this->contactSettings->whatsapp_url,
                    'icon' => asset('legacy-theme/assets/images/wp.svg'),
                ] : null,
                $this->contactSettings->telegram_url !== null ? [
                    'label' => 'Telegram',
                    'url' => $this->contactSettings->telegram_url,
                    'icon' => asset('legacy-theme/assets/images/tg.svg'),
                ] : null,
                $this->contactSettings->vk_url !== null ? [
                    'label' => 'VK',
                    'url' => $this->contactSettings->vk_url,
                    'icon' => asset('legacy-theme/assets/images/vk.svg'),
                ] : null,
            ])),
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
}
