<?php

namespace App\Containers\AppSection\Service\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ServicePrice extends ParentModel
{
    protected $fillable = [
        'service_id',
        'label',
        'price',
    ];

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
