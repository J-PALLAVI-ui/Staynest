<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Pg extends Model
{
    use SoftDeletes;

    protected $table = 'pgs';

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'gender_type',
        'area',
        'city',
        'full_address',
        'lat',
        'lng',
        'description',
        'status',
        'verified',
        'verification_note',
        'female_warden',
        'curfew_time',
        'visitor_policy',
        'security_24x7',
        'cctv_coverage',
        'last_updated',
        'is_stale',
    ];

    protected $casts = [
        'verified'      => 'boolean',
        'female_warden' => 'boolean',
        'security_24x7' => 'boolean',
        'is_stale'      => 'boolean',
        'lat'           => 'float',
        'lng'           => 'float',
        'last_updated'  => 'datetime',
    ];

    // ---------------------------------------------------------------
    // Boot
    // ---------------------------------------------------------------

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Pg $pg) {
            if (empty($pg->slug)) {
                $pg->slug = Str::slug($pg->name) . '-' . Str::random(5);
            }

            $pg->last_updated = now();
        });

        static::updating(function (Pg $pg) {
            $pg->last_updated = now();
            $pg->is_stale = false;
        });
    }

    // ---------------------------------------------------------------
    // Query scopes: boys, girls and live PGs
    // ---------------------------------------------------------------

    public function scopeBoys(Builder $query): Builder
    {
        return $query->where('gender_type', 'boys');
    }

    public function scopeGirls(Builder $query): Builder
    {
        return $query->where('gender_type', 'girls');
    }

    public function scopeLive(Builder $query): Builder
    {
        return $query->where('status', 'live');
    }

    // ---------------------------------------------------------------
    // Find PGs near a college
    // ---------------------------------------------------------------

    public function scopeNearCollege(
        Builder $query,
        float $lat,
        float $lng,
        float $radiusKm = 5
    ): Builder {
        return $query->selectRaw(
            'pgs.*, (
                6371 * ACOS(
                    LEAST(1, GREATEST(-1,
                        COS(RADIANS(?)) *
                        COS(RADIANS(lat)) *
                        COS(RADIANS(lng) - RADIANS(?)) +
                        SIN(RADIANS(?)) *
                        SIN(RADIANS(lat))
                    ))
                )
            ) AS km',
            [$lat, $lng, $lat]
        )
        ->whereNotNull('lat')
        ->whereNotNull('lng')
        ->having('km', '<=', $radiusKm)
        ->orderBy('km');
    }

    // ---------------------------------------------------------------
    // Filters
    // ---------------------------------------------------------------

    public function scopeFilter(
        Builder $query,
        array $filters
    ): Builder {

        /*
         * Apply room-related conditions to one room type.
         * This prevents different room types from separately
         * satisfying the minimum and maximum rent conditions.
         */

        $hasRoomFilters = false;

        foreach ([
            'min_price',
            'max_price',
            'sharing',
            'ac',
            'meals',
            'available',
        ] as $key) {
            if (
                isset($filters[$key]) &&
                $filters[$key] !== '' &&
                $filters[$key] !== false &&
                $filters[$key] !== '0'
            ) {
                $hasRoomFilters = true;
                break;
            }
        }

        if ($hasRoomFilters) {
            $query->whereHas(
                'roomTypes',
                function (Builder $roomQuery) use ($filters) {

                    // Minimum monthly rent
                    if (
                        isset($filters['min_price']) &&
                        $filters['min_price'] !== ''
                    ) {
                        $roomQuery->where(
                            'rent',
                            '>=',
                            (float) $filters['min_price']
                        );
                    }

                    // Maximum monthly rent
                    if (
                        isset($filters['max_price']) &&
                        $filters['max_price'] !== ''
                    ) {
                        $roomQuery->where(
                            'rent',
                            '<=',
                            (float) $filters['max_price']
                        );
                    }

                    // Number of people sharing a room
                    if (
                        isset($filters['sharing']) &&
                        $filters['sharing'] !== ''
                    ) {
                        $roomQuery->where(
                            'sharing',
                            $filters['sharing']
                        );
                    }

                    // Air conditioning
                    if (!empty($filters['ac'])) {
                        $roomQuery->where('ac', true);
                    }

                    // Meals included
                    if (!empty($filters['meals'])) {
                        $roomQuery->where(
                            'meals_included',
                            true
                        );
                    }

                    // At least one free bed
                    if (!empty($filters['available'])) {
                        $roomQuery->where('beds_free', '>', 0);
                    }
                }
            );
        }

        // Filter by area
        if (
            isset($filters['area']) &&
            $filters['area'] !== ''
        ) {
            $query->where('area', $filters['area']);
        }

        // Filter by amenities.
        // Each selected amenity must belong to the PG.
        if (
            !empty($filters['amenities']) &&
            is_array($filters['amenities'])
        ) {
            foreach ($filters['amenities'] as $amenityId) {
                $query->whereHas(
                    'amenities',
                    fn (Builder $amenityQuery) =>
                        $amenityQuery->where(
                            'amenities.id',
                            $amenityId
                        )
                );
            }
        }

        return $query;
    }

    // ---------------------------------------------------------------
    // Relationships
    // ---------------------------------------------------------------

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function roomTypes(): HasMany
    {
        return $this->hasMany(RoomType::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(
            Amenity::class,
            'pg_amenity'
        );
    }

    public function colleges(): BelongsToMany
    {
        return $this->belongsToMany(
            College::class,
            'pg_college_stats'
        )->withPivot('resident_count', 'updated_at');
    }

    public function rules(): HasOne
    {
        return $this->hasOne(PgRule::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)
            ->where('approved', true);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PgPhoto::class)
            ->orderBy('sort_order');
    }

    public function coverPhoto(): HasOne
    {
        return $this->hasOne(PgPhoto::class)
            ->where('is_cover', true);
    }

    // ---------------------------------------------------------------
    // Accessors
    // ---------------------------------------------------------------

    public function getMinRentAttribute(): int
    {
        return (int) ($this->roomTypes()->min('rent') ?? 0);
    }

    public function getAvgRatingAttribute(): float
    {
        return round(
            $this->reviews()->avg('rating') ?? 0,
            1
        );
    }

    public function getCollegeStatsPublicAttribute(): array
    {
        return $this->colleges
            ->filter(
                fn ($college) =>
                    $college->pivot->resident_count >= 3
            )
            ->map(fn ($college) => [
                'name'       => $college->name,
                'count'      => $college->pivot->resident_count,
                'updated_at' => $college->pivot->updated_at,
            ])
            ->values()
            ->toArray();
    }

    public function getIsGirlsAttribute(): bool
    {
        return $this->gender_type === 'girls';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
