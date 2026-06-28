<?php

namespace App\Containers\AppSection\Faq\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

final class Faq extends ParentModel
{
    protected $fillable = [
        'title',
        'slug',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        Faq::saving(static function (Faq $faq): void {
            $faq->slug = $faq->makeUniqueSlug();
        });
    }

    /**
     * @return HasMany<FaqQuestion>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(FaqQuestion::class);
    }

    private function makeUniqueSlug(): string
    {
        $baseSlug = Str::slug($this->title);

        if ($baseSlug === '') {
            $baseSlug = 'faq';
        }

        $slug = $baseSlug;
        $index = 2;

        while (
            Faq::query()
                ->where('slug', $slug)
                ->when($this->exists, fn ($query) => $query->whereKeyNot($this->getKey()))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $index;
            $index++;
        }

        return $slug;
    }
}
