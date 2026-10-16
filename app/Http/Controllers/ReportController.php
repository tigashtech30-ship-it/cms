<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Complaint;
use App\Exports\ComplaintsExport;
use App\Exports\BranchReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $branches        = Branch::all();
        $totalComplaints = Complaint::count();
        $totalResolved   = Complaint::whereIn('status', ['resolved','closed'])->count();
        $totalPending    = Complaint::whereIn('status', ['pending','assigned'])->count();
        $totalInProgress = Complaint::where('status', 'in_progress')->count();

        $branchStats = Branch::withCount([
            'complaints',
            'complaints as resolved_count' => fn($q) => $q->whereIn('status', ['resolved','closed']),
            'complaints as pending_count'  => fn($q) => $q->whereIn('status', ['pending','assigned']),
        ])->get();

        return view('superadmin.reports.index', compact(
            'branches', 'totalComplaints', 'totalResolved',
            'totalPending', 'totalInProgress', 'branchStats'
        ));
    }

    // Excel Downloads
    public function downloadComplaintsExcel(Request $request)
    {
        $filters  = $request->only(['branch_id','status','priority','from_date','to_date']);
        $filename = 'complaints_report_' . now()->format('d_m_Y') . '.xlsx';
        return Excel::download(new ComplaintsExport($filters), $filename);
    }

    public function downloadBranchExcel()
    {
        $filename = 'branch_report_' . now()->format('d_m_Y') . '.xlsx';
        return Excel::download(new BranchReportExport(), $filename);
    }

    // PDF Downloads
    public function downloadComplaintsPdf(Request $request)
    {
        $filters = $request->only(['branch_id','status','priority','from_date','to_date']);

        $query = Complaint::with('branch', 'creator')->latest();

        if (!empty($filters['branch_id']))
            $query->where('branch_id', $filters['branch_id']);
        if (!empty($filters['status']))
            $query->where('status', $filters['status']);
        if (!empty($filters['priority']))
            $query->where('priority', $filters['priority']);
        if (!empty($filters['from_date']))
            $query->whereDate('created_at', '>=', $filters['from_date']);
        if (!empty($filters['to_date']))
            $query->whereDate('created_at', '<=', $filters['to_date']);

        $complaints = $query->get();
        $branches   = Branch::all();

        $pdf = Pdf::loadView('superadmin.reports.complaints_pdf', compact('complaints','filters','branches'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('complaints_report_' . now()->format('d_m_Y') . '.pdf');
    }

    public function downloadBranchPdf()
    {
        $branches = Branch::withCount([
            'complaints',
            'complaints as resolved_count'   => fn($q) => $q->whereIn('status', ['resolved','closed']),
            'complaints as pending_count'    => fn($q) => $q->whereIn('status', ['pending','assigned']),
            'complaints as inprogress_count' => fn($q) => $q->where('status', 'in_progress'),
            'users',
        ])->get();

        $pdf = Pdf::loadView('superadmin.reports.branch_pdf', compact('branches'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('branch_report_' . now()->format('d_m_Y') . '.pdf');
    }
}