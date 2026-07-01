<?php

namespace App\Containers\AppSection\YstTravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class YstSupboardService extends YstTravelModel
{
    protected $table = 'supboard_services';

    protected $fillable = [
        'id',
        'order_id',
        'supboards_count',
        'price',
    ];

    /**
     * @return BelongsTo<YstOrder, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(YstOrder::class, 'order_id');
    }
}
