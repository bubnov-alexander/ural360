<?php

namespace App\Containers\AppSection\Tour\UI\WEB\Controllers;

use App\Containers\AppSection\Tour\Tasks\GetTourPageDataTask;
use App\Ship\Parents\Controllers\WebController;

final class ShowTourPageController extends WebController
{
    public function __construct(
        private readonly GetTourPageDataTask $getTourPageDataTask,
    ) {
    }

    public function __invoke(string $slug)
    {
        return view('public.pages.tour', $this->getTourPageDataTask->run($slug));
    }
}
