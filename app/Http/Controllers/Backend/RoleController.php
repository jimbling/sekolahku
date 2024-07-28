<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use App\Models\User;

class RoleController extends Controller
{
    public function edit(Request $request)
    {
        $users = User::all();
        $judul = 'Edit Hak Akses';
        $permissions = Permission::all();
        $selectedUser = null;
        $userPermissions = [];

        if ($request->has('user_id')) {
            $selectedUser = User::findOrFail($request->input('user_id'));
            $userPermissions = $selectedUser->permissions->pluck('id')->toArray();
        }

        return view('admin.roles', [
            'users' => $users,
            'judul' => $judul,
            'permissions' => $permissions,
            'selectedUser' => $selectedUser,
            'userPermissions' => $userPermissions,
        ]);
    }

    public function updatePermissions(Request $request)
    {
        $userId = $request->input('user_id');
        $permissionIds = $request->input('permissions', []);
        $user = User::findOrFail($userId);
        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        $user->syncPermissions($permissionNames);
        return response()->json(['success' => true, 'message' => 'Hak Akses Pengguna berhasil diperbarui.']);
    }

    public function getUserPermissions($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $permissions = $user->permissions->pluck('id')->unique()->toArray();
            $rolePermissions = $user->roles()->with('permissions')->get()
                ->flatMap(function ($role) {
                    return $role->permissions->pluck('id');
                })
                ->unique()
                ->toArray();
            $allPermissions = array_unique(array_merge($permissions, $rolePermissions));
            return response()->json($allPermissions);
        }
        return response()->json(['error' => 'User not found'], 404);
    }
}
