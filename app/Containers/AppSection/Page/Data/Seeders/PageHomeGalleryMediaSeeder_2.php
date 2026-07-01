<?php

namespace App\Containers\AppSection\Page\Data\Seeders;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;
use Throwable;

final class PageHomeGalleryMediaSeeder_2 extends ParentSeeder
{
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
                    ->addMedia(public_path($path))
                    ->preservingOriginal()
                    ->withCustomProperties([
                        'source' => 'local_imported_wordpress',
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
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/2.2.jpg',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/2.22.jpg',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/2.222.jpg',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/2.png',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/3.3.jpg',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/3.33.webp',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/3.jpg',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/1.1.webp',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/1.11.webp',
            'legacy-theme/assets/images/imported/wp-content/uploads/2025/04/1.jpeg',
        ];
    }
}
