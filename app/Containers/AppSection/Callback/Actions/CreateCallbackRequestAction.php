<?php

namespace App\Containers\AppSection\Callback\Actions;

use App\Containers\AppSection\Callback\Models\CallbackRequest;
use App\Containers\AppSection\Callback\Tasks\CreateCallbackRequestTask;
use App\Containers\AppSection\Callback\Tasks\SendCallbackRequestMailTask;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Log;
use Throwable;

final class CreateCallbackRequestAction extends ParentAction
{
    public function __construct(
        private readonly CreateCallbackRequestTask $createCallbackRequestTask,
        private readonly SendCallbackRequestMailTask $sendCallbackRequestMailTask,
    ) {
    }

    /**
     * @param array{name: string|null, phone: string, comment: string|null, page_url: string|null} $data
     */
    public function run(array $data): CallbackRequest
    {
        $callbackRequest = $this->createCallbackRequestTask->run($data);

        try {
            $this->sendCallbackRequestMailTask->run($callbackRequest);
        } catch (Throwable $exception) {
            Log::error('Failed to send callback request mail.', [
                'callback_request_id' => $callbackRequest->getKey(),
                'exception' => $exception,
            ]);
        }

        return $callbackRequest;
    }
}
