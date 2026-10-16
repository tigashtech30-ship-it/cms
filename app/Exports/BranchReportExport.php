<?php

namespace App\Exports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BranchReportExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Branch::withCount([
            'complaints',
            'complaints as pending_count' => fn($q) => $q->whereIn('status', ['pending','assigned']),
            'complaints as inprogress_count' => fn($q) => $q->where('status', 'in_progress'),
            'complaints as resolved_count' => fn($q) => $q->whereIn('status', ['resolved','closed']),
            'users',
        ])->get()->map(function ($b, $i) {
            return [
                'No'         => $i + 1,
                'Branch'     => $b->name,
                'Code'       => $b->branch_code,
                'Location'   => $b->location ?? '—',
                'Phone'      => $b->phone ?? '—',
                'Users'      => $b->users_count,
                'Total'      => $b->complaints_count,
                'Pending'    => $b->pending_count,
                'InProgress' => $b->inprogress_count,
                'Resolved'   => $b->resolved_count,
                'Status'     => $b->is_active ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#', 'Branch Name', 'Code', 'Location', 'Phone',
            'Users', 'Total Complaints', 'Pending',
            'In Progress', 'Resolved', 'Status'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '1e3a5f']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,  'B' => 25, 'C' => 10,
            'D' => 20, 'E' => 15, 'F' => 8,
            'G' => 18, 'H' => 10, 'I' => 12,
            'J' => 10, 'K' => 10,
        ];
    }
}