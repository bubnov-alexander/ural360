<?php

namespace App\Containers\AppSection\YstTravel\Models;

final class YstAdmin extends YstTravelModel
{
    protected $table = 'admins';

    protected $fillable = [
        'id',
        'user_id',
    ];
}
