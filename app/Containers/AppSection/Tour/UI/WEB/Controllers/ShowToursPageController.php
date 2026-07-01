<?php

namespace App\Containers\AppSection\Tour\UI\WEB\Controllers;

use App\Containers\AppSection\Tour\Tasks\GetToursPageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowToursPageController extends WebController
{
    public function __construct(
        private readonly GetToursPageDataTask $getToursPageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.tours', $this->getToursPageDataTask->run());
    }
}
