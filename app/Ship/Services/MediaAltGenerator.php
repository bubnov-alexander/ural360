<?php

namespace App\Ship\Services;

use App\Containers\AppSection\Page\Models\Page;
use App\Containers\AppSection\Seo\Models\Seo;
use App\Containers\AppSection\Service\Models\Service;
use App\Containers\AppSection\Tour\Models\Tour;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class MediaAltGenerator
{
    public function generate(Media $media): string
    {
        $model = $media->getRelationValue('model') ?? $media->model;
        $collection = (string)$media->getAttribute('collection_name');

        $alt = match (true) {
            $model instanceof Service && $collection === Service::MEDIA_COLLECTION_SERVICE_IMAGE
                => $this->serviceImageAlt($model),
            $model instanceof Tour && $collection === Tour::MEDIA_COLLECTION_TOUR_IMAGE
                => $this->tourImageAlt($model),
            $model instanceof Page && $collection === Page::MEDIA_COLLECTION_HOME_GALLERY
                => $this->pageGalleryAlt($media, $model),
            $model instanceof Seo && $collection === Seo::MEDIA_COLLECTION_SEO_IMAGE
                => $this->seoImageAlt($model),
            default => $this->fallbackAlt($media, $model),
        };

        return $this->normalize($alt);
    }

    public function apply(Media $media, bool $force = false): bool
    {
        if (! $force && $this->hasAlt($media)) {
            return false;
        }

        $media->setCustomProperty('alt', $this->generate($media));
        $media->save();

        return true;
    }

    public function applyOnCreating(Media $media): void
    {
        if ($this->hasAlt($media)) {
            return;
        }

        $media->setCustomProperty('alt', $this->generate($media));
    }

    private function hasAlt(Media $media): bool
    {
        return trim((string)$media->getCustomProperty('alt')) !== '';
    }

    private function serviceImageAlt(Service $service): string
    {
        return $service->getAttribute('title') . ' - услуга Ural 360';
    }

    private function tourImageAlt(Tour $tour): string
    {
        return $tour->getAttribute('title') . ' - маршрут сплава по Чусовой';
    }

    private function pageGalleryAlt(Media $media, Page $page): string
    {
        $position = $this->mediaPosition($media, Page::MEDIA_COLLECTION_HOME_GALLERY);
        $title = $page->getAttribute('title') ?: 'Фотогалерея';

        return 'Фотография сплава по Чусовой - ' . $title . ', фото №' . $position;
    }

    private function seoImageAlt(Seo $seo): string
    {
        $title = $seo->getOgTitle() ?: $seo->getTitle() ?: 'страница Ural 360';

        return $title . ' - изображение для соцсетей';
    }

    private function fallbackAlt(Media $media, ?Model $model): string
    {
        $title = $model?->getAttribute('title')
            ?? $model?->getAttribute('name')
            ?? $model?->getAttribute('slug')
            ?? $media->getAttribute('name')
            ?? pathinfo((string)$media->getAttribute('file_name'), PATHINFO_FILENAME);

        return (string)$title;
    }

    private function mediaPosition(Media $media, string $collection): int
    {
        $model = $media->getRelationValue('model') ?? $media->model;

        if (! method_exists($model, 'getMedia')) {
            return 1;
        }

        $ids = $model->getMedia($collection)
            ->sortBy([
                ['order_column', 'asc'],
                ['id', 'asc'],
            ])
            ->pluck('id')
            ->values();

        $index = $ids->search($media->getKey());

        return $index === false ? $ids->count() + 1 : $index + 1;
    }

    private function normalize(string $alt): string
    {
        $alt = trim((string)preg_replace('/\s+/', ' ', strip_tags($alt)));

        if ($alt === '') {
            return 'Изображение Ural 360';
        }

        return mb_strimwidth($alt, 0, 255, '');
    }
}
