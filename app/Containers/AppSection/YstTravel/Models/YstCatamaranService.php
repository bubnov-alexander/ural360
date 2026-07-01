<?php

namespace App\Containers\AppSection\YstTravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class YstCatamaranService extends YstTravelModel
{
    protected $table = 'catamaran_services';

    protected $fillable = [
        'id',
        'order_id',
        'quantity',
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
