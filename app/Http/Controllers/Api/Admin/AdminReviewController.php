<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class AdminReviewController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:admin|superadmin'),
        ];
    }

    /**
     * Get all reviews (with filters)
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'reviewable']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search by content
        if ($request->has('search')) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        $reviews = $query->latest()->paginate(20);

        return response()->json($reviews);
    }

    /**
     * Approve a review
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        
        $review->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Review approved successfully',
            'review' => $review->fresh(['user', 'reviewable']),
        ]);
    }

    /**
     * Reject a review
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review = Review::findOrFail($id);
        
        $review->update([
            'status' => 'rejected',
            'admin_notes' => $request->reason,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // TODO: Optionally notify user of rejection
        // dispatch(new NotifyUserReviewRejected($review));

        return response()->json([
            'message' => 'Review rejected',
            'review' => $review->fresh(['user', 'reviewable']),
        ]);
    }

    /**
     * Update review (edit content/rating manually)
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'nullable|integer|min:1|max:5',
            'content' => 'nullable|string|min:10',
            'status' => 'nullable|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review = Review::findOrFail($id);
        
        $review->update($request->only(['rating', 'content', 'status', 'admin_notes']));

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review->fresh(['user', 'reviewable']),
        ]);
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully',
        ]);
    }

    /**
     * Get review statistics
     */
    public function stats()
    {
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'rejected' => Review::where('status', 'rejected')->count(),
            'avg_rating' => Review::where('status', 'approved')->avg('rating'),
            'five_star' => Review::where('status', 'approved')->where('rating', 5)->count(),
            'four_star' => Review::where('status', 'approved')->where('rating', 4)->count(),
            'three_star_or_less' => Review::where('rating', '<=', 3)->count(),
        ];

        return response()->json($stats);
    }
}
