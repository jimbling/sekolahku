<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        $judul = "Manajemen Pengguna";
        return view('admin.pengguna.all_pengguna', compact('users', 'judul'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        return response()->json(['message' => 'Pengguna berhasil ditambahkan.']);
    }



    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json(['message' => 'Pengguna berhasil diperbarui.']);
    }


    public function show(User $user)
    {
        return response()->json($user);
    }



    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna dengan role admin tidak dapat dihapus.'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna berhasil dihapus.'
        ]);
    }


    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,writer,student',
        ]);

        $user->syncRoles([$request->role]);

        return response()->json(['message' => 'Role updated']);
    }
}
