<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class AdminClientController extends Controller
{
    /**
     * Get all clients (admin view with seeded status)
     */
    public function index()
    {
        $this->authorize('viewAny', Client::class);

        $clients = Client::orderBy('order')
            ->paginate(20);

        return response()->json($clients);
    }

    /**
     * Get a single client
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);

        return response()->json($client);
    }

    /**
     * Create a new client
     */
    public function store(Request $request)
    {
        $this->authorize('create', Client::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'image' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'website_url' => 'nullable|url',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['is_seeded'] = false; // Manual entries are not seeded

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client created successfully',
            'client' => $client,
        ], 201);
    }

    /**
     * Update a client
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'logo' => 'nullable|string',
            'image' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'website_url' => 'nullable|url',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        $client->update($validated);

        return response()->json([
            'message' => 'Client updated successfully',
            'client' => $client,
        ]);
    }

    /**
     * Delete a client
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully',
        ]);
    }

    /**
     * Restore a deleted client
     */
    public function restore($id)
    {
        $this->authorize('restore', Client::class);

        $client = Client::withTrashed()->findOrFail($id);
        $client->restore();

        return response()->json([
            'message' => 'Client restored successfully',
            'client' => $client,
        ]);
    }
}
