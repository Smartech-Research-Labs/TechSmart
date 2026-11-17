<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\{Product, Service, User, Wishlist};
use App\Notifications\WishlistNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WishlistController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('wishlistable')->get();

        return response()->json(['wishlist' => $wishlists]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'wishlistable_type' => 'required|in:App\\Models\\Product,App\\Models\\Service,App\\Models\\Package,App\\Models\\Bundle',
            'wishlistable_id' => 'required|integer',
        ]);

        $item = $request->wishlistable_type::find($request->wishlistable_id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

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

        // Notify admin users
        $itemName = $item->name ?? $item->title ?? 'Unknown';
        $userName = auth()->user()->name ?? auth()->user()->email;

        $admins = User::role(['admin', 'superadmin'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new WishlistNotification(
                userName: $userName,
                itemType: $request->wishlistable_type,
                itemName: $itemName,
                itemId: $request->wishlistable_id,
            ));
        }

        return response()->json([
            'message' => 'Added to wishlist',
            'wishlist_item' => $wishlist->load('wishlistable'),
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
