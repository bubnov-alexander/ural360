<?php

namespace App\Containers\AppSection\Page\UI\WEB\Controllers;

use App\Containers\AppSection\Page\Tasks\GetGalleryPageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowGalleryPageController extends WebController
{
    public function __construct(
        private readonly GetGalleryPageDataTask $getGalleryPageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.gallery', $this->getGalleryPageDataTask->run());
    }
}
