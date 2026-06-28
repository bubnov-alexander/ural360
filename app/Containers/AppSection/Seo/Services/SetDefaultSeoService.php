<?php

namespace App\Containers\AppSection\Seo\Services;

use App\Containers\AppSection\Seo\Contracts\SeoInterface;
use App\Containers\AppSection\Seo\Tasks\SetDefaultSeoTask;
use Illuminate\Contracts\Pagination\Paginator;

final class SetDefaultSeoService
{
    public static function setSeo(SeoInterface $seo, ?Paginator $paginator = null): void
    {
        app(SetDefaultSeoTask::class)->run($seo, $paginator);
    }
}
