<?php

namespace App\Containers\AppSection\Service\Data\Seeders;

use App\Containers\AppSection\Service\Models\Service;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;
use Throwable;

final class ServiceMediaSeeder_2 extends ParentSeeder
{
    private const BASE_URL = 'https://ural360.ru';

    public function run(): void
    {
        foreach ($this->images() as $title => $path) {
            $service = Service::query()
                ->where('title', $title)
                ->first();

            if ($service === null || $service->getFirstMedia(Service::MEDIA_COLLECTION_SERVICE_IMAGE) !== null) {
                continue;
            }

            try {
                $service
                    ->addMediaFromUrl(self::BASE_URL . $path)
                    ->toMediaCollection(Service::MEDIA_COLLECTION_SERVICE_IMAGE);
            } catch (Throwable) {
                continue;
            }
        }
    }

    /**
     * @return array<string, string>
     */
    private function images(): array
    {
        return [
            'Прокат катамаранов' => '/wp-content/uploads/2022/12/IMG_0090.png',
            'Трансфер' => '/wp-content/uploads/2025/04/IMG_0111.png',
            'Автостоянка' => '/wp-content/uploads/2025/04/IMG_0227.png',
            'Прокат SUP-бордов' => '/wp-content/uploads/2025/04/IMG_0229.png',
        ];
    }
}
