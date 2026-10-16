<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Branch;
use App\Models\Category;
use App\Mail\ComplaintAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('branch', 'creator', 'category')->latest();

    // Search — Complaint No / Customer ID / Name / Title
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('tracking_number', 'like', '%'.$search.'%')
              ->orWhere('customer_id',   'like', '%'.$search.'%')
              ->orWhere('customer_name', 'like', '%'.$search.'%')
              ->orWhere('title',         'like', '%'.$search.'%')
              ->orWhere('description',   'like', '%'.$search.'%');
        });
    }

    // Filters
    if ($request->filled('branch_id'))
        $query->where('branch_id', $request->branch_id);
    if ($request->filled('category_id'))
        $query->where('category_id', $request->category_id);
    if ($request->filled('status'))
        $query->where('status', $request->status);
    if ($request->filled('priority'))
        $query->where('priority', $request->priority);
    if ($request->filled('from_date'))
        $query->whereDate('created_at', '>=', $request->from_date);
    if ($request->filled('to_date'))
        $query->whereDate('created_at', '<=', $request->to_date);

    $complaints = $query->paginate(15)->withQueryString();
    $branches   = Branch::all();
    $categories = Category::when(request('branch_id'), function($q) {
        $q->where('branch_id', request('branch_id'));
    })->where('is_active', true)->get();

    // Overall stats
    $allComplaints = Complaint::all();
    $total      = $allComplaints->count();
    $pending    = $allComplaints->whereIn('status', ['pending','assigned'])->count();
    $inProgress = $allComplaints->where('status', 'in_progress')->count();
    $resolved   = $allComplaints->whereIn('status', ['resolved','closed'])->count();

    // Branch-wise stats
    $branchStats = Branch::withCount([
        'complaints',
        'complaints as branch_pending'    => fn($q) => $q->whereIn('status',['pending','assigned']),
        'complaints as branch_inprogress' => fn($q) => $q->where('status','in_progress'),
        'complaints as branch_resolved'   => fn($q) => $q->whereIn('status',['resolved','closed']),
    ])->get();

    return view('admin.complaints.index', compact(
        'complaints', 'branches', 'categories',
        'total', 'pending', 'inProgress', 'resolved',
        'branchStats'
    ));
    }

    public function create()
    {
        $branches   = Branch::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin.complaints.create', compact('branches', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'   => 'required|string|max:100',
            'customer_name' => 'required|string|max:255',
            'complaint_type' => 'required|in:assessment_tax_payer,general_complaint',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'branch_id'     => 'required|exists:branches,id',
            'category_id'   => 'required|exists:categories,id',
            'priority'      => 'required|in:low,medium,high,urgent',
            'attachment'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Tracking number = Customer ID
        $trackingNumber = strtoupper($request->customer_id);

        // File upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                                      ->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'tracking_number' => $trackingNumber,
            'customer_id'     => $request->customer_id,
            'customer_name'   => $request->customer_name,
            'complaint_type'  => $request->complaint_type,
            'title'           => $request->title,
            'description'     => $request->description,
            'branch_id'       => $request->branch_id,
            'category_id'     => $request->category_id,
            'priority'        => $request->priority,
            'status'          => 'assigned',
            'created_by'      => Auth::id(),
            'assigned_at'     => now(),
            'admin_note'      => $request->admin_note,
            'attachment'      => $attachmentPath,
        ]);

        // Email notification
        $complaint->load('branch', 'category');
        $branchUsers = \App\Models\User::where('branch_id', $complaint->branch_id)
                                       ->where('role', 'user')
                                       ->get();
        foreach ($branchUsers as $user) {
            Mail::to($user->email)->send(new ComplaintAssigned($complaint));
        }

        return redirect()->route('admin.complaints.index')
                         ->with('success', 'Complaint #'.$trackingNumber.' registered successfully!');
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('branch', 'creator', 'category');
        return view('admin.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $branches   = Branch::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin.complaints.edit', compact('complaint', 'branches', 'categories'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'branch_id'   => 'required|exists:branches,id',
            'category_id' => 'nullable|exists:categories,id',
            'priority'    => 'required|in:low,medium,high,urgent',
            'status'      => 'required|in:pending,assigned,in_progress,resolved,closed',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            if ($complaint->attachment) {
                Storage::disk('public')->delete($complaint->attachment);
            }
            $data['attachment'] = $request->file('attachment')
                                          ->store('complaints', 'public');
        }

        $complaint->update($data);

        return redirect()->route('admin.complaints.index')
                         ->with('success', 'Complaint updated successfully!');
    }

    public function destroy(Complaint $complaint)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        if ($complaint->attachment) {
            Storage::disk('public')->delete($complaint->attachment);
        }
        $complaint->delete();
        return redirect()->route('admin.complaints.index')
                         ->with('success', 'Complaint deleted successfully!');
    }

    public function print(Complaint $complaint)
    {
        $complaint->load('branch', 'creator', 'category');
        return view('admin.complaints.print', compact('complaint'));
    }
}