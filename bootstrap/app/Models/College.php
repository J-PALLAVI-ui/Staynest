<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class College extends Model
{
    protected $fillable = ['name', 'short_name', 'area', 'city', 'lat', 'lng', 'slug'];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    public function pgs(): BelongsToMany
    {
        return $this->belongsToMany(Pg::class, 'pg_college_stats')
                    ->withPivot('resident_count', 'updated_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
