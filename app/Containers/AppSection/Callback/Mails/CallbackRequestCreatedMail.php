<?php

namespace App\Containers\AppSection\Callback\Mails;

use App\Containers\AppSection\Callback\Models\CallbackRequest;
use App\Containers\AppSection\Settings\Settings\ContactSettings;
use App\Ship\Parents\Mails\Mail as ParentMail;

final class CallbackRequestCreatedMail extends ParentMail
{
    public readonly string $siteName;

    public readonly string $siteUrl;

    public function __construct(
        public readonly CallbackRequest $callbackRequest,
        ContactSettings $settings,
    ) {
        $this->siteName = $settings->site_name;
        $this->siteUrl = $settings->site_url;
    }

    public function build(): self
    {
        return $this
            ->subject('Новая заявка с сайта ' . $this->siteName)
            ->view('mail.callback-request-created', [
                'callbackRequest' => $this->callbackRequest,
                'siteName' => $this->siteName,
                'siteUrl' => $this->siteUrl,
            ]);
    }
}
