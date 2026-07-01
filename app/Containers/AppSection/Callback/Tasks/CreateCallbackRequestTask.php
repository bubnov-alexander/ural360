<?php

namespace App\Containers\AppSection\Callback\Tasks;

use App\Containers\AppSection\Callback\Enums\CallbackStatus;
use App\Containers\AppSection\Callback\Models\CallbackRequest;
use App\Ship\Parents\Tasks\Task as ParentTask;

final class CreateCallbackRequestTask extends ParentTask
{
    /**
     * @param array{name: string|null, phone: string, comment: string|null, page_url: string|null} $data
     */
    public function run(array $data): CallbackRequest
    {
        return CallbackRequest::query()->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'comment' => $data['comment'],
            'page_url' => $data['page_url'],
            'status' => CallbackStatus::NEW,
        ]);
    }
}
