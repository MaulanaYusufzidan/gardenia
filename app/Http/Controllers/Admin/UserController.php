<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')->latest();

        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('orders.payment');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,'.$user->id,
            'role'    => 'required|in:user,admin',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password'=> 'nullable|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'role', 'phone', 'address');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun pengguna berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
