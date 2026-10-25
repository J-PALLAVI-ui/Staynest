<?php

namespace App\Http\Controllers;

use App\Models\Pg;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Admin access only.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'pending'  => Pg::where('status', 'pending')->count(),
            'live'     => Pg::where('status', 'live')->count(),
            'stale'    => Pg::where('is_stale', true)->count(),
            'owners'   => User::where('role', 'owner')->count(),
            'students' => User::where('role', 'student')->count(),
        ];

        $pendingPgs = Pg::where('status', 'pending')->with('owner', 'photos')->latest()->get();

        return view('admin.dashboard', compact('stats', 'pendingPgs'));
    }

    public function listings(Request $request)
    {
        $query = Pg::with('owner')->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('gender')) {
            $query->where('gender_type', $request->gender);
        }
        $pgs = $query->paginate(25);
        return view('admin.listings', compact('pgs'));
    }

    public function approve(Pg $pg)
    {
        $pg->update(['status' => 'live', 'last_updated' => now()]);
        return back()->with('success', "PG '{$pg->name}' is now live.");
    }

    public function reject(Request $request, Pg $pg)
    {
        $request->validate(['note' => 'nullable|string|max:300']);
        $pg->update(['status' => 'rejected', 'verification_note' => $request->note]);
        return back()->with('success', "PG '{$pg->name}' rejected.");
    }

    public function verify(Pg $pg)
    {
        $pg->update(['verified' => true]);
        return back()->with('success', "Verified badge granted to '{$pg->name}'.");
    }

    public function suspend(Pg $pg)
    {
        $pg->update(['status' => 'suspended']);
        return back()->with('success', "PG '{$pg->name}' suspended.");
    }

    /**
     * Approve a user review.
     */
    public function approveReview(\App\Models\Review $review)
    {
        $review->update(['approved' => true]);
        return back()->with('success', 'Review approved.');
    }

    public function verifyResident(\App\Models\Review $review)
    {
        $review->update(['verified_resident' => true]);
        return back()->with('success', 'Resident status verified.');
    }

    public function analytics()
    {
        $byArea = Pg::live()->selectRaw('area, COUNT(*) as count')
            ->groupBy('area')->orderByDesc('count')->get();

        $popularColleges = \App\Models\College::withCount('pgs')
            ->orderByDesc('pgs_count')->take(10)->get();

        return view('admin.analytics', compact('byArea', 'popularColleges'));
    }
}
