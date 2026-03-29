<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        // Count users per role via pivot table directly to avoid
        // Spatie's guard-model resolution issue in API context
        $userCounts = DB::table('model_has_roles')
            ->select('role_id', DB::raw('count(*) as count'))
            ->groupBy('role_id')
            ->pluck('count', 'role_id');

        $roles->each(function ($role) use ($userCounts) {
            $role->users_count = $userCounts[$role->id] ?? 0;
        });

        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:64|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json([
            'message' => 'Role created',
            'role' => $role->load('permissions'),
        ], 201);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:64|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        if (isset($validated['name'])) {
            $role->update(['name' => $validated['name']]);
        }

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json([
            'message' => 'Role updated',
            'role' => $role->fresh('permissions'),
        ]);
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['superadmin', 'admin', 'user'])) {
            return response()->json(['message' => 'Cannot delete system roles'], 403);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted']);
    }

    public function permissions()
    {
        return response()->json(Permission::orderBy('name')->pluck('name'));
    }
}
