<?php

namespace App\Containers\AppSection\YstTravel\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

final class YstRoute extends YstTravelModel
{
    protected $table = 'routes';

    protected $fillable = [
        'id',
        'point_a',
        'point_b',
    ];

    /**
     * @return HasMany<YstOrder>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(YstOrder::class, 'route_id');
    }

    public function getTitleAttribute(): string
    {
        return trim((string)$this->getAttribute('point_a') . ' - ' . (string)$this->getAttribute('point_b'));
    }
}
