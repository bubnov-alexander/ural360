<?php

namespace App\Containers\AppSection\Service\UI\WEB\Controllers;

use App\Containers\AppSection\Service\Tasks\GetServicesPageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowServicesPageController extends WebController
{
    public function __construct(
        private readonly GetServicesPageDataTask $getServicesPageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.services', $this->getServicesPageDataTask->run());
    }
}
