<?php

namespace App\Containers\AppSection\Callback\Tasks;

use App\Containers\AppSection\Callback\Mails\CallbackRequestCreatedMail;
use App\Containers\AppSection\Callback\Models\CallbackRequest;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Facades\Mail;

final class SendCallbackRequestMailTask extends ParentTask
{
    public function __construct(
        private readonly ContactSettings $contactSettings,
    ) {
    }

    public function run(CallbackRequest $callbackRequest): void
    {
        Mail::to($this->contactSettings->email)
            ->send(new CallbackRequestCreatedMail($callbackRequest, $this->contactSettings));
    }
}
