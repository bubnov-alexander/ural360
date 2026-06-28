<?php

namespace App\Containers\AppSection\Seo\Contracts;

use App\Containers\AppSection\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface SeoInterface
{
    public function getSeoTitle(): ?string;

    public function getSeoDescription(): ?string;

    public function getSeoKeywords(): ?string;

    public function getSeoOgTitle(): ?string;

    public function getSeoOgDescription(): ?string;

    public function getSeoOgImage(): ?string;

    public function seo(): MorphOne;

    public function getSeo(): ?Seo;
}
