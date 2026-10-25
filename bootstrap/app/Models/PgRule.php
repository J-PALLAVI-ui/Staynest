<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PgRule extends Model
{
    protected $table = 'rules';

    protected $fillable = [
        'pg_id', 'curfew', 'visitors', 'smoking_allowed', 'alcohol_allowed',
        'cooking_allowed', 'pets_policy', 'noise_policy', 'other_rules',
    ];

    protected $casts = [
        'smoking_allowed' => 'boolean',
        'alcohol_allowed' => 'boolean',
        'cooking_allowed' => 'boolean',
    ];

    public function pg(): BelongsTo
    {
        return $this->belongsTo(Pg::class);
    }
}
