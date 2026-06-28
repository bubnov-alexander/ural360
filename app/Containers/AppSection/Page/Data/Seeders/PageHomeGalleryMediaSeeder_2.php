<?php

namespace App\Containers\AppSection\Page\Data\Seeders;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;
use Throwable;

final class PageHomeGalleryMediaSeeder_2 extends ParentSeeder
{
    private const BASE_URL = 'https://ural360.ru';

    public function run(): void
    {
        $page = Page::query()
            ->where('type', PageType::HOME)
            ->orderBy('id')
            ->first();

        if ($page === null) {
            return;
        }

        foreach ($this->images() as $path) {
            if ($page->getMedia(Page::MEDIA_COLLECTION_HOME_GALLERY)->contains(
                fn ($media): bool => $media->file_name === basename($path),
            )) {
                continue;
            }

            try {
                $page
                    ->addMediaFromUrl(self::BASE_URL . $path)
                    ->withCustomProperties([
                        'source' => 'old_wordpress',
                        'source_path' => $path,
                    ])
                    ->toMediaCollection(Page::MEDIA_COLLECTION_HOME_GALLERY);
            } catch (Throwable) {
                continue;
            }
        }
    }

    /**
     * @return array<int, string>
     */
    private function images(): array
    {
        return [
            '/wp-content/uploads/2025/04/2.2.jpg',
            '/wp-content/uploads/2025/04/2.22.jpg',
            '/wp-content/uploads/2025/04/2.222.jpg',
            '/wp-content/uploads/2025/04/2.png',
            '/wp-content/uploads/2025/04/3.3.jpg',
            '/wp-content/uploads/2025/04/3.33.webp',
            '/wp-content/uploads/2025/04/3.jpg',
            '/wp-content/uploads/2025/04/1.1.webp',
            '/wp-content/uploads/2025/04/1.11.webp',
            '/wp-content/uploads/2025/04/1.jpeg',
        ];
    }
}
