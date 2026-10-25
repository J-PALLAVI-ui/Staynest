<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['pg_id', 'user_id', 'rating', 'text', 'verified_resident', 'approved'];

    protected $casts = [
        'verified_resident' => 'boolean',
        'approved'          => 'boolean',
    ];

    public function pg(): BelongsTo
    {
        return $this->belongsTo(Pg::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
