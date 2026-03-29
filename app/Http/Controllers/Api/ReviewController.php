<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Notifications\ReviewNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', only: ['store']),
        ];
    }

    public function index($type, $id)
    {
        $reviewableType = match ($type) {
            'service' => 'App\\Models\\Service',
            'product' => 'App\\Models\\Product',
            default => null,
        };

        if (!$reviewableType) {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        $reviews = Review::where('reviewable_type', $reviewableType)
            ->where('reviewable_id', $id)
            ->approved()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reviewable_type' => 'required|in:App\\Models\\Service,App\\Models\\Product',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Auto-approve logic: 4-5 stars auto-approve, 1-3 stars go to moderation
        $status = $request->rating >= 4 ? 'approved' : 'pending';

        $review = Review::create([
            'user_id' => auth()->id(),
            'reviewable_type' => $request->reviewable_type,
            'reviewable_id' => $request->reviewable_id,
            'rating' => $request->rating,
            'content' => $request->content,
            'status' => $status,
        ]);

        // Notify admins about the new review
        $reviewableName = '';
        $reviewable = $review->reviewable;
        if ($reviewable) {
            $reviewableName = $reviewable->name ?? $reviewable->title ?? 'Item';
        }
        $admins = User::role(['admin', 'superadmin', 'super-admin'])->get();
        Notification::send($admins, new ReviewNotification(
            auth()->user()->name,
            class_basename($request->reviewable_type),
            $reviewableName,
            $review->id,
            $request->rating,
        ));

        $message = $status === 'approved' 
            ? 'Thank you! Your review has been published.' 
            : 'Review submitted for moderation. Reviews with 3 stars or below are reviewed by our team.';

        return response()->json([
            'message' => $message,
            'review' => $review,
            'auto_approved' => $status === 'approved',
        ], 201);
    }
}
