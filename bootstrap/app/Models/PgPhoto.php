<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PgPhoto extends Model
{
    protected $fillable = ['pg_id', 's3_path', 'alt_text', 'is_cover', 'sort_order'];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    public function pg(): BelongsTo
    {
        return $this->belongsTo(Pg::class);
    }

    public function getUrlAttribute(): string
    {
        // Use S3 URL or local storage fallback
        if (str_starts_with($this->s3_path, 'http')) {
            return $this->s3_path;
        }
        return asset('storage/' . $this->s3_path);
    }
}
