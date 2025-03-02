<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.manage-users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.manage-users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'user_level' => 'required|in:admin,officer',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6',
            'alamat' => 'nullable|string',
            'no_handphone' => 'nullable|string|max:15',
        ]);
    
        User::create([
            'nama' => $request->nama,
            'user_level' => $request->user_level,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_handphone' => $request->no_handphone,
        ]);
        // dd($user);
        return redirect()->route('admin.manage-users.index')->with('success', 'User berhasil ditambahkan.');
    }
        

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.manage-users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'user_level' => 'required|in:admin,officer',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6',
            'alamat' => 'nullable|string',
            'no_handphone' => 'nullable|string|max:15',
        ]);

        $user->update([
            'nama' => $request->nama,
            'user_level' => $request->user_level,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'alamat' => $request->alamat,
            'no_handphone' => $request->no_handphone,
        ]);

        return redirect()->route('admin.manage-users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.manage-users.index')->with('success', 'User berhasil dihapus.');
    }
}
