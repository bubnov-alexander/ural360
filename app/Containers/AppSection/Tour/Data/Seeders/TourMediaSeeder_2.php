<?php

namespace App\Containers\AppSection\Tour\Data\Seeders;

use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;
use Throwable;

final class TourMediaSeeder_2 extends ParentSeeder
{
    private const BASE_URL = 'https://ural360.ru';

    public function run(): void
    {
        foreach ($this->images() as $title => $path) {
            $tour = Tour::query()
                ->where('title', $title)
                ->first();

            if ($tour === null || $tour->getFirstMedia(Tour::MEDIA_COLLECTION_TOUR_IMAGE) !== null) {
                continue;
            }

            try {
                $tour
                    ->addMediaFromUrl(self::BASE_URL . $path)
                    ->toMediaCollection(Tour::MEDIA_COLLECTION_TOUR_IMAGE);
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
            'Сплав по Чусовой: Усть-Утка - Ёква, 24 км' => '/wp-content/uploads/2025/04/IMG_0195.png',
            'Сплав по Чусовой: Сулём - Ёква, 40 км' => '/wp-content/uploads/2025/04/IMG_0200.png',
            'Маршрут «Индивидуальный»' => '/wp-content/uploads/2025/04/IMG_0203.png',
            'Маршрут Усть-Утка - Верхняя Ослянка, 86 км' => '/wp-content/uploads/2025/04/IMG_0201.png',
        ];
    }
}
