<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller to manage trashed (soft-deleted) items across all CMS models.
 */
class TrashController extends Controller
{
    /**
     * Map of model keys to their Eloquent class.
     */
    private function modelMap(): array
    {
        return [
            'services'  => \App\Models\Service::class,
            'products'  => \App\Models\Product::class,
            'bundles'   => \App\Models\Bundle::class,
            'blogs'     => \App\Models\Blog::class,
            'sliders'   => \App\Models\Slider::class,
            'clients'   => \App\Models\Client::class,
            'counters'  => \App\Models\CounterItem::class,
            'pages'     => \App\Models\Page::class,
            'reviews'   => \App\Models\Review::class,
            'enquiries' => \App\Models\Enquiry::class,
        ];
    }

    /**
     * List all trashed items for a given model type.
     * GET /admin/trash/{type}
     */
    public function index(string $type)
    {
        $model = $this->resolveModel($type);
        if (!$model) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        $items = $model::onlyTrashed()->latest('deleted_at')->paginate(20);

        return response()->json($items);
    }

    /**
     * Restore a single soft-deleted item.
     * POST /admin/trash/{type}/{id}/restore
     */
    public function restore(string $type, int $id)
    {
        $model = $this->resolveModel($type);
        if (!$model) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        $item = $model::onlyTrashed()->findOrFail($id);
        $item->restore();

        return response()->json([
            'message' => ucfirst(rtrim($type, 's')) . ' restored successfully',
            'item' => $item,
        ]);
    }

    /**
     * Permanently delete a soft-deleted item.
     * DELETE /admin/trash/{type}/{id}
     */
    public function forceDelete(string $type, int $id)
    {
        $model = $this->resolveModel($type);
        if (!$model) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        $item = $model::onlyTrashed()->findOrFail($id);
        $item->forceDelete();

        return response()->json([
            'message' => ucfirst(rtrim($type, 's')) . ' permanently deleted',
        ]);
    }

    /**
     * Restore all trashed items for a given type.
     * POST /admin/trash/{type}/restore-all
     */
    public function restoreAll(string $type)
    {
        $model = $this->resolveModel($type);
        if (!$model) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        $count = $model::onlyTrashed()->count();
        $model::onlyTrashed()->restore();

        return response()->json([
            'message' => "Restored {$count} " . $type,
        ]);
    }

    /**
     * Resolve the Eloquent model class from the type string.
     */
    private function resolveModel(string $type): ?string
    {
        return $this->modelMap()[$type] ?? null;
    }
}
