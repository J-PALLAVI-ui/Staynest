<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    protected $fillable = [
        'pg_id', 'user_id', 'student_name', 'phone', 'email',
        'message', 'status', 'address_revealed_at',
    ];

    protected $casts = [
        'address_revealed_at' => 'datetime',
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
