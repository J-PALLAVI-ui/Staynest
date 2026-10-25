<?php

namespace App\Http\Controllers;

use App\Models\Pg;
use App\Models\RoomType;
use App\Models\PgRule;
use App\Models\PgPhoto;
use App\Models\Amenity;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isOwner() && !Auth::user()->isAdmin()) {
                abort(403, 'Owner access required.');
            }
            return $next($request);
        });
    }

    // -------------------------------------------------------------------
    // Dashboard
    // -------------------------------------------------------------------
    public function dashboard()
    {
        $pgs = Auth::user()->pgs()->with('roomTypes', 'enquiries', 'coverPhoto')->get();
        return view('owner.dashboard', compact('pgs'));
    }

    // -------------------------------------------------------------------
    // Wizard: Step 1 — basic details
    // -------------------------------------------------------------------
    public function createStep1()
    {
        return view('owner.wizard.step1');
    }

    public function storeStep1(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'gender_type' => ['required', Rule::in(['boys', 'girls'])],
            'area'        => 'required|string|max:100',
            'description' => 'nullable|string|max:2000',
        ]);

        $pg = Auth::user()->pgs()->create($data);

        return redirect()->route('owner.wizard.step2', $pg)->with('success', 'Step 1 saved!');
    }

    // -------------------------------------------------------------------
    // Wizard: Step 2 — location pin
    // -------------------------------------------------------------------
    public function createStep2(Pg $pg)
    {
        $this->authorisePg($pg);
        return view('owner.wizard.step2', compact('pg'));
    }

    public function storeStep2(Request $request, Pg $pg)
    {
        $this->authorisePg($pg);

        $data = $request->validate([
            'lat'          => 'required|numeric|between:-90,90',
            'lng'          => 'required|numeric|between:-180,180',
            'full_address' => 'required|string|max:500',
        ]);

        $pg->update($data);
        return redirect()->route('owner.wizard.step3', $pg);
    }

    // -------------------------------------------------------------------
    // Wizard: Step 3 — room types and prices
    // -------------------------------------------------------------------
    public function createStep3(Pg $pg)
    {
        $this->authorisePg($pg);
        return view('owner.wizard.step3', compact('pg'));
    }

    public function storeStep3(Request $request, Pg $pg)
    {
        $this->authorisePg($pg);

        $request->validate([
            'rooms'                   => 'required|array|min:1',
            'rooms.*.sharing'         => 'required|integer|between:1,4',
            'rooms.*.ac'              => 'nullable|boolean',
            'rooms.*.rent'            => 'required|integer|min:1',
            'rooms.*.deposit'         => 'nullable|integer|min:0',
            'rooms.*.beds_total'      => 'required|integer|min:1',
            'rooms.*.beds_free'       => 'required|integer|min:0',
            'rooms.*.meals_included'  => 'nullable|boolean',
            'rooms.*.electricity_extra' => 'nullable|integer|min:0',
            'rooms.*.laundry_extra'   => 'nullable|integer|min:0',
        ]);

        // Sync room types
        $pg->roomTypes()->delete();
        foreach ($request->rooms as $room) {
            $pg->roomTypes()->create([
                'sharing'           => $room['sharing'],
                'ac'                => $room['ac'] ?? false,
                'rent'              => $room['rent'],
                'deposit'           => $room['deposit'] ?? 0,
                'beds_total'        => $room['beds_total'],
                'beds_free'         => $room['beds_free'],
                'meals_included'    => $room['meals_included'] ?? false,
                'electricity_extra' => $room['electricity_extra'] ?? 0,
                'laundry_extra'     => $room['laundry_extra'] ?? 0,
            ]);
        }

        return redirect()->route('owner.wizard.step4', $pg);
    }

    // -------------------------------------------------------------------
    // Wizard: Step 4 — amenities checklist
    // -------------------------------------------------------------------
    public function createStep4(Pg $pg)
    {
        $this->authorisePg($pg);
        $amenities = Amenity::all()->groupBy('category');
        return view('owner.wizard.step4', compact('pg', 'amenities'));
    }

    public function storeStep4(Request $request, Pg $pg)
    {
        $this->authorisePg($pg);

        $pg->amenities()->sync($request->input('amenities', []));

        // Girls-only safety fields
        if ($pg->gender_type === 'girls') {
            $safetyData = $request->validate([
                'female_warden'  => 'nullable|boolean',
                'curfew_time'    => 'nullable|string|max:20',
                'visitor_policy' => 'nullable|string|max:200',
                'security_24x7'  => 'nullable|boolean',
                'cctv_coverage'  => 'nullable|string|max:200',
            ]);
            $pg->update($safetyData);
        }

        // Rules
        $rulesData = $request->validate([
            'curfew'          => 'nullable|string|max:100',
            'visitors'        => 'nullable|string|max:200',
            'smoking_allowed' => 'nullable|boolean',
            'alcohol_allowed' => 'nullable|boolean',
            'cooking_allowed' => 'nullable|boolean',
            'other_rules'     => 'nullable|string|max:500',
        ]);
        $pg->rules()->updateOrCreate(['pg_id' => $pg->id], $rulesData);

        return redirect()->route('owner.wizard.step5', $pg);
    }

    // -------------------------------------------------------------------
    // Wizard: Step 5 — photos upload
    // -------------------------------------------------------------------
    public function createStep5(Pg $pg)
    {
        $this->authorisePg($pg);
        return view('owner.wizard.step5', compact('pg'));
    }

    public function storeStep5(Request $request, Pg $pg)
    {
        $this->authorisePg($pg);

        $request->validate([
            'photos'         => 'required|array|min:1|max:10',
            'photos.*'       => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        foreach ($request->file('photos') as $i => $file) {
            $path = $file->store("pgs/{$pg->id}", 'public');
            $pg->photos()->create([
                's3_path'   => $path,
                'alt_text'  => $pg->name . ' photo ' . ($i + 1),
                'is_cover'  => $i === 0 && $pg->photos()->count() === 0,
                'sort_order' => $i,
            ]);
        }

        // Mark ready for review
        $pg->update(['status' => 'pending']);

        return redirect()->route('owner.dashboard')->with('success', 'Your PG has been submitted for verification!');
    }

    // -------------------------------------------------------------------
    // Quick vacancy update (one-tap)
    // -------------------------------------------------------------------
    public function updateVacancy(Request $request, Pg $pg)
    {
        $this->authorisePg($pg);

        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'beds_free'    => 'required|integer|min:0',
        ]);

        $pg->roomTypes()->findOrFail($request->room_type_id)->update([
            'beds_free' => $request->beds_free,
        ]);
        $pg->update(['last_updated' => now(), 'is_stale' => false]);

        return back()->with('success', 'Vacancy updated!');
    }

    // -------------------------------------------------------------------
    // Resident count update (college mix)
    // -------------------------------------------------------------------
    public function updateCollegeStats(Request $request, Pg $pg)
    {
        $this->authorisePg($pg);

        $request->validate([
            'college_id'      => 'required|exists:colleges,id',
            'resident_count'  => 'required|integer|min:0',
        ]);

        $pg->colleges()->syncWithoutDetaching([
            $request->college_id => [
                'resident_count' => $request->resident_count,
                'updated_at'     => now(),
            ]
        ]);

        return back()->with('success', 'College stats updated!');
    }

    // -------------------------------------------------------------------
    // Owner analytics
    // -------------------------------------------------------------------
    public function analytics(Pg $pg)
    {
        $this->authorisePg($pg);

        $enquiriesByDay = $pg->enquiries()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->take(30)
            ->get();

        return view('owner.analytics', compact('pg', 'enquiriesByDay'));
    }

    // -------------------------------------------------------------------
    // Edit existing PG
    // -------------------------------------------------------------------
    public function edit(Pg $pg)
    {
        $this->authorisePg($pg);
        $amenities = Amenity::all()->groupBy('category');
        $colleges  = College::all();
        return view('owner.edit', compact('pg', 'amenities', 'colleges'));
    }

    public function update(Request $request, Pg $pg)
    {
        $this->authorisePg($pg);

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'area'           => 'required|string|max:100',
            'description'    => 'nullable|string|max:2000',
            'female_warden'  => 'nullable|boolean',
            'curfew_time'    => 'nullable|string|max:20',
            'visitor_policy' => 'nullable|string|max:200',
            'security_24x7'  => 'nullable|boolean',
            'cctv_coverage'  => 'nullable|string|max:200',
        ]);

        $pg->update($data);
        $pg->amenities()->sync($request->input('amenities', []));

        return back()->with('success', 'PG updated!');
    }

    // -------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------
    private function authorisePg(Pg $pg): void
    {
        if ($pg->owner_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
    }
}
