<?php

namespace App\Containers\AppSection\Page\UI\WEB\Controllers;

use App\Containers\AppSection\Page\Tasks\GetHomePageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowHomePageController extends WebController
{
    public function __construct(
        private readonly GetHomePageDataTask $getHomePageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.home', $this->getHomePageDataTask->run());
    }
}
