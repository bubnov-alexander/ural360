<?php

namespace App\Containers\AppSection\Faq\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class FaqQuestion extends ParentModel
{
    protected $fillable = [
        'faq_id',
        'question',
        'answer',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * @return BelongsTo<Faq, $this>
     */
    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }
}
