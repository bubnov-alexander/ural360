<?php

namespace App\Containers\AppSection\Seo\Traits;

use App\Containers\AppSection\Seo\Enums\SeoFieldType;
use App\Containers\AppSection\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeoTrait
{
    /**
     * @return MorphOne<Seo, $this>
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model');
    }

    public function getSeo(): ?Seo
    {
        return $this->seo;
    }

    public function getSeoValue(SeoFieldType $seoField, ?string $modelFallbackField = null): ?string
    {
        $seo = $this->seo;

        if ($seo !== null) {
            if ($seoField === SeoFieldType::OG_IMAGE) {
                return $seo->getOgImageUrl();
            }

            $seoFieldValue = $seoField->value;
            $value = $seo->{$seoFieldValue};

            if (! empty($value)) {
                return $value;
            }
        }

        return $modelFallbackField !== null ? ($this->{$modelFallbackField} ?? null) : null;
    }
}
