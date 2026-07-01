<?php

namespace App\Containers\AppSection\Service\Data\Seeders;

use App\Containers\AppSection\Service\Models\Service;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;
use Throwable;

final class ServiceMediaSeeder_2 extends ParentSeeder
{
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
                    ->addMedia(public_path($path))
                    ->preservingOriginal()
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
            'Прокат катамаранов' => 'legacy-theme/assets/images/imported/wp-content/uploads/2022/12/service-catamarans.png',
            'Трансфер' => 'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/service-transfer.png',
            'Автостоянка' => 'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/service-parking.png',
            'Прокат SUP-бордов' => 'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/service-supboards.png',
        ];
    }
}
