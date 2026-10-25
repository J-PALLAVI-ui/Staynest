<?php

namespace App\Http\Controllers;

use App\Models\Pg;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Pg $pg)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'text'   => 'nullable|string|max:1000',
        ]);

        // Only one review per user per PG
        Review::updateOrCreate(
            ['pg_id' => $pg->id, 'user_id' => Auth::id()],
            [
                'rating'            => $request->rating,
                'text'              => $request->text,
                'verified_resident' => false, // admin sets this after verification
                'approved'          => false,  // admin approves
            ]
        );

        return back()->with('success', 'Review submitted for moderation. Thank you!');
    }
}
