<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\{Product, Service, Wishlist};
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('wishlistable')->get();

        return response()->json($wishlists);
    }

    public function store(Request $request)
    {
        $request->validate([
            'wishlistable_type' => 'required|in:App\\Models\\Product,App\\Models\\Service',
            'wishlistable_id' => 'required|integer',
        ]);

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('wishlistable_type', $request->wishlistable_type)
            ->where('wishlistable_id', $request->wishlistable_id)
            ->first();

        if ($exists) {
            return response()->json(['message' => 'Already in wishlist'], 200);
        }

        $wishlist = Wishlist::create([
            'user_id' => auth()->id(),
            'wishlistable_type' => $request->wishlistable_type,
            'wishlistable_id' => $request->wishlistable_id,
        ]);

        return response()->json([
            'message' => 'Added to wishlist',
            'wishlist' => $wishlist->load('wishlistable'),
        ], 201);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $wishlist->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }
}
