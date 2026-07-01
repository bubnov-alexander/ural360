<?php

namespace App\Containers\AppSection\Seo\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Services\MediaAltGenerator;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class Seo extends ParentModel implements HasMedia
{
    use InteractsWithMedia;

    public const string MEDIA_COLLECTION_SEO_IMAGE = 'seo';

    protected $table = 'seo';

    protected $fillable = [
        'title',
        'description',
        'og_title',
        'og_description',
        'keywords',
        'model_id',
        'model_type',
    ];

    protected static function booted(): void
    {
        Media::creating(static function (Media $media): void {
            if (
                ! $media->model instanceof Seo
                || $media->collection_name !== self::MEDIA_COLLECTION_SEO_IMAGE
            ) {
                return;
            }

            app(MediaAltGenerator::class)->applyOnCreating($media);
        });
    }

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_SEO_IMAGE)
            ->singleFile();
    }

    public function getOgImageUrl(): ?string
    {
        $mediaUrl = $this->getFirstMediaUrl(self::MEDIA_COLLECTION_SEO_IMAGE);

        return $mediaUrl !== '' ? $mediaUrl : null;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getOgTitle(): ?string
    {
        return $this->og_title;
    }

    public function setOgTitle(?string $ogTitle): void
    {
        $this->og_title = $ogTitle;
    }

    public function getOgDescription(): ?string
    {
        return $this->og_description;
    }

    public function setOgDescription(?string $ogDescription): void
    {
        $this->og_description = $ogDescription;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): void
    {
        $this->keywords = $keywords;
    }
}
