<?php

namespace App\Containers\AppSection\Faq\UI\WEB\Controllers;

use App\Containers\AppSection\Faq\Tasks\GetQuestionsPageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowQuestionsPageController extends WebController
{
    public function __construct(
        private readonly GetQuestionsPageDataTask $getQuestionsPageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.questions', $this->getQuestionsPageDataTask->run());
    }
}
