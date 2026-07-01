<?php

namespace App\Containers\AppSection\Callback\Models;

use App\Containers\AppSection\Callback\Enums\CallbackStatus;
use App\Ship\Parents\Models\Model as ParentModel;

final class CallbackRequest extends ParentModel
{
    protected $table = 'callback_requests';

    protected $fillable = [
        'name',
        'phone',
        'comment',
        'page_url',
        'status',
    ];

    protected $casts = [
        'status' => CallbackStatus::class,
    ];
}
