<?php

namespace App\Containers\AppSection\Page\UI\WEB\Controllers;

use App\Containers\AppSection\Page\Tasks\GetContactsPageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowContactsPageController extends WebController
{
    public function __construct(
        private readonly GetContactsPageDataTask $getContactsPageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.contacts', $this->getContactsPageDataTask->run());
    }
}
