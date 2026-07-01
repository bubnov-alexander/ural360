<?php

namespace App\Containers\AppSection\YstTravel\Models;

final class YstSetting extends YstTravelModel
{
    protected $table = 'settings';

    protected $fillable = [
        'id',
        'key',
        'value',
    ];
}
