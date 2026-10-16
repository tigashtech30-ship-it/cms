<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Branch;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('branch')->withCount('complaints');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $categories = $query->latest()->get();
        $branches   = Branch::where('is_active', true)->get();

        return view('admin.categories.index', compact('categories', 'branches'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.categories.create', compact('branches'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'branch_id'   => 'required|exists:branches,id',
        'name'        => 'required|string|max:255',
        'code'        => [
            'required',
            'string',
            'max:20',
            // Same branch-ல் same code வரக்கூடாது
            \Illuminate\Validation\Rule::unique('categories')
                ->where('branch_id', $request->branch_id),
        ],
        'description' => 'nullable|string',
    ], [
        'code.unique' => 'This code already exists for the selected branch.',
    ]);

    Category::create($request->all());

    return redirect()->route('admin.categories.index')
                     ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.categories.edit', compact('category', 'branches'));
    }

    public function update(Request $request, Category $category)
    {
    $request->validate([
        'branch_id'   => 'required|exists:branches,id',
        'name'        => 'required|string|max:255',
        'code'        => [
            'required',
            'string',
            'max:20',
            // Same branch-ல் same code வரக்கூடாது — current record தவிர
            \Illuminate\Validation\Rule::unique('categories')
                ->where('branch_id', $request->branch_id)
                ->ignore($category->id),
        ],
        'description' => 'nullable|string',
    ], [
        'code.unique' => 'This code already exists for the selected branch.',
    ]);

    $category->update($request->all());

    return redirect()->route('admin.categories.index')
                     ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category deleted!');
    }
}