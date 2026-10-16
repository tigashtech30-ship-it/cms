<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('branch')
                     ->where('role', 'user')
                     ->latest()
                     ->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.users.create', compact('branches'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'name'      => 'required|string|max:255|min:3',
        'email'     => 'required|email|unique:users|max:255',
        'password'  => [
            'required',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ],
        'branch_id' => 'required|exists:branches,id',
    ], [
        'name.min'         => 'Name must be at least 3 characters.',
        'password.min'     => 'Password must be at least 8 characters.',
        'password.regex'   => 'Password must contain uppercase, lowercase and number.',
        'password.confirmed' => 'Passwords do not match.',
        'branch_id.required' => 'Please select a branch.',
    ]);

    User::create([
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
        'role'      => 'user',
        'branch_id' => $request->branch_id,
    ]);

    return redirect()->route('admin.users.index')
                     ->with('success', 'User successfully created!');
    }

    public function edit(User $user)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.users.edit', compact('user', 'branches'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'branch_id' => 'required|exists:branches,id',
            'password'  => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'branch_id' => $request->branch_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User successfully updated!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', 'User successfully deleted!');
    }
}