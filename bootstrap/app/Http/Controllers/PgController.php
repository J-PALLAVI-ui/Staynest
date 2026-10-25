<?php

namespace App\Http\Controllers;

use App\Models\Pg;
use App\Models\College;
use App\Models\Amenity;
use Illuminate\Http\Request;

class PgController extends Controller
{
    /**
     * Home page â€” featured PGs for boys and girls.
     */
    public function home()
    {
        $boysPgs = Pg::live()
            ->boys()
            ->with('coverPhoto', 'roomTypes', 'amenities')
            ->latest('last_updated')
            ->take(6)
            ->get();

        $girlsPgs = Pg::live()
            ->girls()
            ->with('coverPhoto', 'roomTypes', 'amenities')
            ->latest('last_updated')
            ->take(6)
            ->get();

        $colleges = College::orderBy('name')->get();

        return view('home', compact('boysPgs', 'girlsPgs', 'colleges'));
    }

    /**
     * Boys or girls PG listing page.
     */
    public function index(Request $request, string $section)
    {
        $genderType = $section === 'girls' ? 'girls' : 'boys';

        $query = Pg::live()
            ->where('gender_type', $genderType)
            ->with('coverPhoto', 'roomTypes', 'amenities');

        $college = null;

        if ($request->filled('college_id')) {
            $college = College::find($request->college_id);
        } elseif ($request->filled('college')) {
            $college = College::where('slug', $request->college)->first();
        }

        if ($college && $college->lat !== null && $college->lng !== null) {
            $query->nearCollege(
                $college->lat,
                $college->lng,
                (float) $request->get('radius', 5)
            );
        }

        $query->filter($request->only([
            'min_price',
            'max_price',
            'sharing',
            'ac',
            'meals',
            'amenities',
            'area',
            'available',
        ]));

        $pgs = $query->paginate(12)->withQueryString();

        $amenities = Amenity::all()->groupBy('category');
        $colleges = College::orderBy('name')->get();

        $areas = Pg::live()
            ->where('gender_type', $genderType)
            ->distinct()
            ->pluck('area');

        $accent = $genderType === 'girls' ? 'rose' : 'blue';

        return view('pgs.index', compact(
            'pgs',
            'amenities',
            'colleges',
            'areas',
            'section',
            'genderType',
            'accent',
            'college'
        ));
    }

    /**
     * PG details page.
     */
    public function show(Request $request, string $section, string $pg)
    {
        $pg = Pg::where('slug', $pg)->firstOrFail();

        $expectedGender = $section === 'girls' ? 'girls' : 'boys';

        if ($pg->gender_type !== $expectedGender) {
            abort(404);
        }

        $pg->load(
            'roomTypes',
            'amenities',
            'photos',
            'rules',
            'reviews.user',
            'colleges',
            'owner'
        );

        $nearbyColleges = collect();

        if ($pg->lat !== null && $pg->lng !== null) {
            $nearbyColleges = College::all()
                ->map(function ($college) use ($pg) {
                    if ($college->lat === null || $college->lng === null) {
                        return null;
                    }

                    $distance = $this->haversine(
                        (float) $pg->lat,
                        (float) $pg->lng,
                        (float) $college->lat,
                        (float) $college->lng
                    );

                    return [
                        'college' => $college,
                        'km' => round($distance, 1),
                    ];
                })
                ->filter()
                ->sortBy('km')
                ->values()
                ->take(5);
        }

        $collegeStats = $pg->college_stats_public;
        $accent = $pg->gender_type === 'girls' ? 'rose' : 'blue';

        return view('pgs.show', compact(
            'pg',
            'nearbyColleges',
            'collegeStats',
            'section',
            'accent'
        ));
    }

    /**
     * Area landing page.
     */
    public function area(string $section, string $area)
    {
        $genderType = $section === 'girls' ? 'girls' : 'boys';

        $pgs = Pg::live()
            ->where('gender_type', $genderType)
            ->where('area', $area)
            ->with('coverPhoto', 'roomTypes')
            ->get();

        $accent = $genderType === 'girls' ? 'rose' : 'blue';

        $title = ucfirst($genderType)
            . ' PG in '
            . ucwords(str_replace('-', ' ', $area))
            . ', Bangalore';

        return view('pgs.area', compact(
            'pgs',
            'genderType',
            'section',
            'area',
            'accent',
            'title'
        ));
    }

    /**
     * College landing page.
     * Uses PHP distance calculations for SQLite compatibility.
     */
    public function nearCollege(string $college, string $section)
    {
        $college = College::where('slug', $college)->firstOrFail();

        $genderType = $section === 'girls' ? 'girls' : 'boys';

        $accent = $genderType === 'girls' ? 'rose' : 'blue';

        $title = ucfirst($genderType)
            . ' PG near '
            . $college->name
            . ', Bangalore';

        if ($college->lat === null || $college->lng === null) {
            $pgs = collect();
        } else {
            $pgs = Pg::live()
                ->where('gender_type', $genderType)
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->with('coverPhoto', 'roomTypes', 'amenities')
                ->get()
                ->map(function ($pg) use ($college) {
                    $pg->distance_km = round(
                        $this->haversine(
                            (float) $college->lat,
                            (float) $college->lng,
                            (float) $pg->lat,
                            (float) $pg->lng
                        ),
                        2
                    );

                    return $pg;
                })
                ->filter(function ($pg) {
                    return $pg->distance_km <= 5;
                })
                ->sortBy('distance_km')
                ->values();
        }

        return view('pgs.near-college', compact(
            'pgs',
            'college',
            'genderType',
            'section',
            'accent',
            'title'
        ));
    }

    /**
     * Compare up to three PGs.
     */
    public function compare(Request $request)
    {
        $slugs = array_slice(
            (array) $request->get('slugs', []),
            0,
            3
        );

        $pgs = Pg::live()
            ->whereIn('slug', $slugs)
            ->with('amenities', 'roomTypes', 'coverPhoto')
            ->get();

        return view('pgs.compare', compact('pgs'));
    }

    /**
     * AJAX endpoint for filtered results.
     */
    public function search(Request $request, string $section)
    {
        $genderType = $section === 'girls' ? 'girls' : 'boys';

        $query = Pg::live()
            ->where('gender_type', $genderType)
            ->with('coverPhoto', 'roomTypes', 'amenities');

        $college = null;

        if ($request->filled('college_id')) {
            $college = College::find($request->college_id);
        } elseif ($request->filled('college')) {
            $college = College::where('slug', $request->college)->first();
        }

        if ($college && $college->lat !== null && $college->lng !== null) {
            $query->nearCollege(
                $college->lat,
                $college->lng,
                (float) $request->get('radius', 5)
            );
        }

        $query->filter($request->only([
            'min_price',
            'max_price',
            'sharing',
            'ac',
            'meals',
            'amenities',
            'area',
            'available',
        ]));

        $pgs = $query->paginate(12)->withQueryString();
        $accent = $genderType === 'girls' ? 'rose' : 'blue';

        return view('pgs.partials.pg-cards', compact(
            'pgs',
            'section',
            'accent'
        ))->render();
    }

    /**
     * Calculate distance between two coordinates in kilometres.
     */
    private function haversine(
        float $lat1,
        float $lng1,
        float $lat2,
        float $lng2
    ): float {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1))
            * cos(deg2rad($lat2))
            * sin($dLng / 2) ** 2;

        $a = min(1, max(0, $a));

        return 2 * $earthRadius * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );
    }
}
