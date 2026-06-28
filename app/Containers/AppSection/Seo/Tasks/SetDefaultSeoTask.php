<?php

namespace App\Containers\AppSection\Seo\Tasks;

use App\Containers\AppSection\Seo\Contracts\SeoInterface;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Request;

final class SetDefaultSeoTask extends ParentTask
{
    public function run(SeoInterface $seo, ?Paginator $paginator = null): void
    {
        $title = $seo->getSeoTitle();
        $description = $seo->getSeoDescription();
        $ogTitle = $seo->getSeoOgTitle();
        $ogDescription = $seo->getSeoOgDescription();
        $ogImage = $seo->getSeoOgImage();
        $keywords = $seo->getSeoKeywords();

        if ($paginator !== null && $paginator->currentPage() > 1) {
            $pageString = ' - Страница ' . $paginator->currentPage() . ' из ' . $paginator->lastPage();
            $title .= $pageString;
            $description .= $pageString;
            $ogTitle .= $pageString;
            $ogDescription .= $pageString;
        } elseif (Request::has('page') && (int)Request::get('page') > 1) {
            $pageString = ' - Страница ' . (int)Request::get('page');
            $title .= $pageString;
            $description .= $pageString;
            $ogTitle .= $pageString;
            $ogDescription .= $pageString;
        }

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);

        if (! empty($keywords)) {
            SEOMeta::setKeywords($keywords);
        }

        OpenGraph::setTitle($ogTitle);
        OpenGraph::setSiteName(config('app.name'));
        OpenGraph::setDescription($ogDescription);

        if ($ogImage !== null) {
            OpenGraph::addImage($ogImage);
        }

        JsonLdMulti::setTitle($title);
        JsonLdMulti::setDescription($description);
    }
}
