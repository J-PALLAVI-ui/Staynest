<?php

namespace App\Http\Controllers;

use App\Models\Pg;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    /**
     * Student sends enquiry — triggers address reveal.
     */
    public function store(Request $request, Pg $pg)
    {
        $data = $request->validate([
            'student_name' => 'required|string|max:100',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:100',
            'message'      => 'nullable|string|max:500',
        ]);

        $data['pg_id']              = $pg->id;
        $data['user_id']            = Auth::id();
        $data['address_revealed_at'] = now(); // address is now available to this student

        $enquiry = Enquiry::create($data);

        // TODO: send email to owner via SES (use queued job in production)

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'address' => $pg->full_address,
                'message' => 'Enquiry sent! The owner will contact you. Here is the address: ' . $pg->full_address,
            ]);
        }

        return back()->with('success', 'Enquiry sent! Full address: ' . $pg->full_address);
    }

    /**
     * Owner views their enquiries.
     */
    public function ownerIndex(Pg $pg)
    {
        abort_unless(Auth::id() === $pg->owner_id || Auth::user()->isAdmin(), 403);
        $enquiries = $pg->enquiries()->latest()->paginate(20);
        return view('owner.enquiries', compact('pg', 'enquiries'));
    }
}
