<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount('users', 'complaints')->latest()->get();
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'branch_code' => 'required|string|unique:branches|max:50',
            'location'    => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
        ]);

        Branch::create($request->all());

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch successfully created!');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'branch_code' => 'required|string|unique:branches,branch_code,' . $branch->id . '|max:50',
            'location'    => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
        ]);

        $branch->update($request->all());

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch successfully updated!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch successfully deleted!');
    }
}