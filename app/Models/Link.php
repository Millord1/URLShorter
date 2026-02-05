<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

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
