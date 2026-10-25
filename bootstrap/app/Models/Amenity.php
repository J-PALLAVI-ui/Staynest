<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'icon'];

    public function pgs(): BelongsToMany
    {
        return $this->belongsToMany(Pg::class, 'pg_amenity');
    }
}
