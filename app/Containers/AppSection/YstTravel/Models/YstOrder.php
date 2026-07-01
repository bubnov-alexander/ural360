<?php

namespace App\Containers\AppSection\YstTravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class YstOrder extends YstTravelModel
{
    protected $table = 'orders';

    protected $fillable = [
        'id',
        'date_arrival',
        'time_arrival',
        'date_departure',
        'time_departure',
        'route_id',
        'customer_name',
        'phone',
        'prepayment_status',
        'additional_wishes',
    ];

    protected $casts = [
        'prepayment_status' => 'boolean',
    ];

    /**
     * @return BelongsTo<YstRoute, $this>
     */
    public function route(): BelongsTo
    {
        return $this->belongsTo(YstRoute::class, 'route_id');
    }

    /**
     * @return HasMany<YstCatamaranService>
     */
    public function catamaranServices(): HasMany
    {
        return $this->hasMany(YstCatamaranService::class, 'order_id');
    }

    /**
     * @return HasMany<YstTransferService>
     */
    public function transferServices(): HasMany
    {
        return $this->hasMany(YstTransferService::class, 'order_id');
    }

    /**
     * @return HasMany<YstSupboardService>
     */
    public function supboardServices(): HasMany
    {
        return $this->hasMany(YstSupboardService::class, 'order_id');
    }
}
