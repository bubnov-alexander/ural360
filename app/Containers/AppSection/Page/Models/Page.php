<?php

namespace App\Containers\AppSection\Page\Models;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Seo\Contracts\SeoInterface;
use App\Containers\AppSection\Seo\Enums\SeoFieldType;
use App\Containers\AppSection\Seo\Models\Seo;
use App\Containers\AppSection\Seo\Traits\HasSeoTrait;
use App\Ship\Parents\Models\Model as ParentModel;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class Page extends ParentModel implements HasMedia, SeoInterface
{
    use HasSeoTrait;
    use InteractsWithMedia;

    public const string MEDIA_COLLECTION_HOME_GALLERY = 'home_gallery';

    protected $fillable = [
        'title',
        'slug',
        'type',
        'content',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'type' => PageType::class,
    ];

    protected static function booted(): void
    {
        static::saving(static function (Page $page): void {
            $page->slug = $page->makeUniqueSlug();
        });

        static::saved(static function (Page $page): void {
            $page->syncGeneratedSeo();
        });
    }

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_HOME_GALLERY);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->optimize()
            ->nonQueued();
    }

    private function makeUniqueSlug(): string
    {
        $baseSlug = Str::slug($this->title);

        if ($baseSlug === '') {
            $baseSlug = 'page';
        }

        $slug = $baseSlug;
        $index = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($this->exists, fn ($query) => $query->whereKeyNot($this->getKey()))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $index;
            $index++;
        }

        return $slug;
    }

    private function syncGeneratedSeo(): void
    {
        $seo = $this->seo()->firstOrNew();
        $description = $this->makeSeoDescription();

        if (empty($seo->title)) {
            $seo->title = $this->title;
        }

        if (empty($seo->og_title)) {
            $seo->og_title = $this->title;
        }

        if ($description !== null && empty($seo->description)) {
            $seo->description = $description;
        }

        if ($description !== null && empty($seo->og_description)) {
            $seo->og_description = $description;
        }

        if (! $seo->exists || $seo->isDirty()) {
            $seo->save();
        }
    }

    private function makeSeoDescription(): ?string
    {
        $content = trim((string)$this->content);

        if ($content === '') {
            return null;
        }

        $text = trim((string)preg_replace('/\s+/', ' ', strip_tags($content)));

        return $text !== '' ? Str::limit($text, 255, '') : null;
    }

    public function getSeoTitle(): ?string
    {
        return $this->getSeoValue(SeoFieldType::TITLE, 'title');
    }

    public function getSeoDescription(): ?string
    {
        return $this->getSeoValue(SeoFieldType::DESCRIPTION);
    }

    public function getSeoKeywords(): ?string
    {
        return $this->getSeoValue(SeoFieldType::KEYWORDS);
    }

    public function getSeoOgTitle(): ?string
    {
        return $this->getSeoValue(SeoFieldType::OG_TITLE, 'title');
    }

    public function getSeoOgDescription(): ?string
    {
        return $this->getSeoValue(SeoFieldType::OG_DESCRIPTION);
    }

    public function getSeoOgImage(): ?string
    {
        return $this->getSeoValue(SeoFieldType::OG_IMAGE);
    }

    public function getSeo(): ?Seo
    {
        return $this->seo;
    }
}
