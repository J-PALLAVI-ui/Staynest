<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomType extends Model
{
    protected $fillable = [
        'pg_id', 'sharing', 'ac', 'rent', 'deposit',
        'beds_total', 'beds_free', 'meals_included',
        'electricity_extra', 'laundry_extra', 'notes',
    ];

    protected $casts = [
        'ac'             => 'boolean',
        'meals_included' => 'boolean',
    ];

    public function pg(): BelongsTo
    {
        return $this->belongsTo(Pg::class);
    }

    /**
     * True monthly cost estimate (rent + extras, optionally deposit amortised over 6 months).
     */
    public function trueMonthlyCost(bool $includeDepositAmortised = true): int
    {
        $base = $this->rent + $this->electricity_extra + $this->laundry_extra;
        if ($includeDepositAmortised) {
            $base += intval($this->deposit / 6);
        }
        return $base;
    }
}
