<?php

namespace App\Containers\AppSection\Page\UI\WEB\Controllers;

use App\Containers\AppSection\Page\Tasks\GetAboutPageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowAboutPageController extends WebController
{
    public function __construct(
        private readonly GetAboutPageDataTask $getAboutPageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.about', $this->getAboutPageDataTask->run());
    }
}
