<?php

namespace App\Containers\AppSection\Page\UI\WEB\Controllers;

use App\Containers\AppSection\Page\Tasks\GetPrivacyPolicyPageDataTask;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;

final class ShowPrivacyPolicyPageController extends WebController
{
    public function __construct(
        private readonly GetPrivacyPolicyPageDataTask $getPrivacyPolicyPageDataTask,
    ) {
    }

    public function __invoke(): View
    {
        return view('public.pages.privacy-policy', $this->getPrivacyPolicyPageDataTask->run());
    }
}
