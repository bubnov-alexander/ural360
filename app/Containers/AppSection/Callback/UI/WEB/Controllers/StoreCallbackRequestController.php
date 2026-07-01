<?php

namespace App\Containers\AppSection\Callback\UI\WEB\Controllers;

use App\Containers\AppSection\Callback\Actions\CreateCallbackRequestAction;
use App\Containers\AppSection\Callback\UI\WEB\Requests\StoreCallbackRequestRequest;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

final class StoreCallbackRequestController extends WebController
{
    public function __construct(
        private readonly CreateCallbackRequestAction $createCallbackRequestAction,
    ) {
    }

    public function __invoke(StoreCallbackRequestRequest $request): JsonResponse|RedirectResponse
    {
        $this->createCallbackRequestAction->run($request->callbackData());

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Заявка успешно отправлена',
            ]);
        }

        return back()->with('callback_success', true);
    }
}
