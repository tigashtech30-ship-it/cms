<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Branch;
use App\Models\Complaint;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // Overall Stats
        $totalBranches   = Branch::count();
        $totalUsers      = User::where('role', 'user')->count();
        $totalComplaints = Complaint::count();
        $totalResolved   = Complaint::whereIn('status', ['resolved', 'closed'])->count();
        $totalPending    = Complaint::whereIn('status', ['pending', 'assigned'])->count();
        $totalInProgress = Complaint::where('status', 'in_progress')->count();

        // Recent Complaints
        $recentComplaints = Complaint::with('branch', 'creator')
                                     ->latest()
                                     ->take(10)
                                     ->get();

        // Branch wise stats
        $branches = Branch::withCount('complaints')
                          ->with(['complaints' => function($q) {
                              $q->select('branch_id', 'status');
                          }])
                          ->get();

        // All Users
        $users = User::with('branch')
                     ->where('role', 'user')
                     ->latest()
                     ->get();

        return view('superadmin.dashboard', compact(
            'totalBranches', 'totalUsers', 'totalComplaints',
            'totalResolved', 'totalPending', 'totalInProgress',
            'recentComplaints', 'branches', 'users'
        ));
    }

    

    public function complaints(Request $request)
    {
    $query = Complaint::with('branch', 'creator', 'category')->latest();

    // Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('tracking_number', 'like', '%'.$search.'%')
              ->orWhere('customer_id',   'like', '%'.$search.'%')
              ->orWhere('customer_name', 'like', '%'.$search.'%')
              ->orWhere('title',         'like', '%'.$search.'%');
        });
    }

    if ($request->filled('branch_id'))
        $query->where('branch_id', $request->branch_id);
    if ($request->filled('status'))
        $query->where('status', $request->status);
    if ($request->filled('priority'))
        $query->where('priority', $request->priority);
    if ($request->filled('complaint_type'))
    $query->where('complaint_type', $request->complaint_type);

    $complaints = $query->paginate(15)->withQueryString();
    $branches   = Branch::all();

    $total      = Complaint::count();
    $pending    = Complaint::whereIn('status', ['pending','assigned'])->count();
    $inProgress = Complaint::where('status', 'in_progress')->count();
    $resolved   = Complaint::whereIn('status', ['resolved','closed'])->count();

    $branchStats = Branch::withCount([
        'complaints',
        'complaints as branch_pending'    => fn($q) => $q->whereIn('status',['pending','assigned']),
        'complaints as branch_inprogress' => fn($q) => $q->where('status','in_progress'),
        'complaints as branch_resolved'   => fn($q) => $q->whereIn('status',['resolved','closed']),
    ])->get();

    return view('superadmin.complaints', compact(
        'complaints', 'branches',
        'total', 'pending', 'inProgress', 'resolved',
        'branchStats'
    ));
    }

    public function branches()
    {
        $branches = Branch::withCount('users', 'complaints')->latest()->get();
        return view('superadmin.branches', compact('branches'));
    }

    public function users()
    {
        $users = User::with('branch')
                     ->where('role', '!=', 'super_admin')
                     ->latest()
                     ->get();
        return view('superadmin.users', compact('users'));
    }
    public function complaintShow(Complaint $complaint)
    {
    $complaint->load('branch', 'creator', 'category');
    return view('superadmin.complaint_show', compact('complaint'));
    }
}