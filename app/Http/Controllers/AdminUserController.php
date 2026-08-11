<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Akses khusus Admin');
        }

        $search = $request->query('search');
        $roleFilter = $request->query('role');

        $query = User::query();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (! empty($roleFilter) && in_array($roleFilter, ['student', 'educator', 'admin'])) {
            $query->where('role', $roleFilter);
        }

        $users = $query->latest()->get();

        $stats = [
            'total' => User::count(),
            'students' => User::where('role', 'student')->count(),
            'educators' => User::where('role', 'educator')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats', 'search', 'roleFilter'));
    }
    public function store(Request $request)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Akses khusus Admin');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
            'role' => ['required', Rule::in(['student', 'educator', 'admin'])],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->back()->with('success', 'User ' . $validated['name'] . ' berhasil ditambahkan!');
    }

    public function update(Request $request, User $user)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Akses khusus Admin');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['student', 'educator', 'admin'])],
            'password' => 'nullable|string|min:4',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        if ($user->id === auth()->id() && $user->role !== 'admin') {
            return redirect()->route('dashboard')->with('success', 'Role akun Anda berhasil diubah menjadi ' . ucfirst($user->role) . '! Tampilan dashboard telah disesuaikan.');
        }

        return redirect()->back()->with('success', 'Data user ' . $user->name . ' (Role: ' . ucfirst($user->role) . ') berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Akses khusus Admin');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->back()->with('success', 'User ' . $name . ' berhasil dihapus!');
    }
}
