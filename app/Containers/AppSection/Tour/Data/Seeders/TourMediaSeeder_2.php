<?php

namespace App\Containers\AppSection\Tour\Data\Seeders;

use App\Containers\AppSection\Tour\Models\Tour;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;
use Throwable;

final class TourMediaSeeder_2 extends ParentSeeder
{
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
                    ->addMedia(public_path($path))
                    ->preservingOriginal()
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
            'Сплав по Чусовой: Усть-Утка - Ёква, 24 км' => 'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/tour-ust-utka-yokva.png',
            'Сплав по Чусовой: Сулём - Ёква, 40 км' => 'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/tour-sulem-yokva.png',
            'Маршрут «Индивидуальный»' => 'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/tour-individual.png',
            'Маршрут Усть-Утка - Верхняя Ослянка, 86 км' => 'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/tour-ust-utka-oslyanka.png',
        ];
    }
}
