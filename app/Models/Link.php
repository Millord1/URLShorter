<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'short_code',
        'original_url',
        'clicks_count',
        'last_used_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('User');
    }

}
