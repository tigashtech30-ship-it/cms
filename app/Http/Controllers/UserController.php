<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Mail\ComplaintStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user   = Auth::user();
        $branch = $user->branch;

        $query = Complaint::where('branch_id', $user->branch_id)->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tracking_number', 'like', '%'.$search.'%')
                  ->orWhere('customer_id',   'like', '%'.$search.'%')
                  ->orWhere('customer_name', 'like', '%'.$search.'%')
                  ->orWhere('title',         'like', '%'.$search.'%');
            });
        }

        if ($request->filled('status'))
            $query->where('status', $request->status);
        if ($request->filled('priority'))
            $query->where('priority', $request->priority);
        // Complaint Type filter
        if ($request->filled('complaint_type'))
            $query->where('complaint_type', $request->complaint_type);

        $complaints = $query->paginate(10)->withQueryString();

        $allBranch  = Complaint::where('branch_id', $user->branch_id)->get();
        $total      = $allBranch->count();
        $pending    = $allBranch->whereIn('status', ['pending','assigned'])->count();
        $inProgress = $allBranch->where('status', 'in_progress')->count();
        $resolved   = $allBranch->whereIn('status', ['resolved','closed'])->count();

        return view('user.dashboard', compact(
            'user', 'branch', 'complaints',
            'total', 'pending', 'inProgress', 'resolved'
        ));
    }

    public function show(Complaint $complaint)
    {
        if ($complaint->branch_id !== Auth::user()->branch_id) {
            abort(403);
        }
        $complaint->load('branch', 'category', 'creator');
        return view('user.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        if ($complaint->branch_id !== Auth::user()->branch_id) {
            abort(403);
        }

        $request->validate([
            'status'            => 'required|in:in_progress,resolved',
            'note'              => 'nullable|string|max:500',
            'branch_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = [
            'status'     => $request->status,
            'admin_note' => $complaint->admin_note . ($request->note
                ? "\n\n[Branch Note - " . now()->format('d M Y h:i A') . "]: " . $request->note
                : ''),
        ];

        // Branch attachment upload
        if ($request->hasFile('branch_attachment')) {
            if ($complaint->branch_attachment) {
                Storage::disk('public')->delete($complaint->branch_attachment);
            }
            $data['branch_attachment'] = $request->file('branch_attachment')
                                                  ->store('branch_attachments', 'public');
        }

        $complaint->update($data);

        // Admin-க்கு email
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ComplaintStatusUpdated($complaint));
        }

        return redirect()->route('user.complaint.show', $complaint)
                         ->with('success', 'Status updated successfully!');
    }
}