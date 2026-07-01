<?php

namespace App\Containers\AppSection\YstTravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class YstTransferService extends YstTravelModel
{
    protected $table = 'transfer_services';

    protected $fillable = [
        'id',
        'order_id',
        'vehicle_type',
        'route_id',
        'persons_count',
        'driver_included',
        'price',
    ];

    protected $casts = [
        'driver_included' => 'boolean',
    ];

    /**
     * @return BelongsTo<YstOrder, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(YstOrder::class, 'order_id');
    }

    /**
     * @return BelongsTo<YstRoute, $this>
     */
    public function route(): BelongsTo
    {
        return $this->belongsTo(YstRoute::class, 'route_id');
    }
}
