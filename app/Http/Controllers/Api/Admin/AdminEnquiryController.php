<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class AdminEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::with(['user', 'enquirable']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $enquiries = $query->latest()->paginate(20);

        return response()->json($enquiries);
    }

    public function show(Enquiry $enquiry)
    {
        return response()->json($enquiry->load(['user', 'enquirable']));
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:new,in-progress,resolved,closed',
            'internal_notes' => 'nullable|string|max:2000',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $enquiry->update($validated);

        return response()->json([
            'message' => 'Enquiry updated',
            'enquiry' => $enquiry->fresh(['user', 'enquirable']),
        ]);
    }

    public function reply(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'reply' => 'required|string|min:5',
        ]);

        $enquiry->update([
            'internal_notes' => $request->reply,
            'status' => 'in-progress',
        ]);

        return response()->json([
            'message' => 'Reply sent',
            'enquiry' => $enquiry->fresh(['user', 'enquirable']),
        ]);
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return response()->json(['message' => 'Enquiry deleted']);
    }

    public function stats()
    {
        return response()->json([
            'total' => Enquiry::count(),
            'new' => Enquiry::where('status', 'new')->count(),
            'in_progress' => Enquiry::where('status', 'in-progress')->count(),
            'resolved' => Enquiry::where('status', 'resolved')->count(),
        ]);
    }
}
