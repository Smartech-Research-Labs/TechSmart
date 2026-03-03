<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'user' => $user,
            'stats' => [
                'wishlists' => $user->wishlists()->count(),
                'enquiries' => $user->enquiries()->count(),
                'reviews' => $user->reviews()->count(),
                'pending_reviews' => $user->reviews()->pending()->count(),
            ],
        ]);
    }

    public function enquiries()
    {
        $enquiries = auth()->user()
            ->enquiries()
            ->with('enquirable')
            ->latest()
            ->paginate(10);

        return response()->json($enquiries);
    }

    public function reviews()
    {
        $reviews = auth()->user()
            ->reviews()
            ->with('reviewable')
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }

    public function profile(Request $request)
    {
        $user = auth()->user();

        if ($request->isMethod('put')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'company' => 'nullable|string|max:255',
                'bio' => 'nullable|string|max:1000',
            ]);

            $user->update($request->only(['name', 'email', 'phone', 'company', 'bio']));

            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user->fresh(),
            ]);
        }

        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->update(['password' => \Hash::make($request->password)]);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
