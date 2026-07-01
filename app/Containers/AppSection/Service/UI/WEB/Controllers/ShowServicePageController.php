<?php

namespace App\Containers\AppSection\Service\UI\WEB\Controllers;

use App\Containers\AppSection\Service\Tasks\GetServicePageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowServicePageController extends WebController
{
    public function __construct(
        private readonly GetServicePageDataTask $getServicePageDataTask,
    ) {
    }

    public function __invoke(string $slug): View
    {
        return view('public.pages.service', $this->getServicePageDataTask->run($slug));
    }
}
