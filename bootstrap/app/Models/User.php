<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // -------------------------------------------------------------------
    // Role helpers
    // -------------------------------------------------------------------
    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isOwner(): bool  { return $this->role === 'owner'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    // -------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------
    public function pgs(): HasMany
    {
        return $this->hasMany(Pg::class, 'owner_id');
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
