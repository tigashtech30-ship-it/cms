<?php

namespace App\Exports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComplaintsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Complaint::with('branch', 'creator')->latest();

        if (!empty($this->filters['branch_id'])) {
            $query->where('branch_id', $this->filters['branch_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['priority'])) {
            $query->where('priority', $this->filters['priority']);
        }
        if (!empty($this->filters['from_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['from_date']);
        }
        if (!empty($this->filters['to_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['to_date']);
        }

        return $query->get()->map(function ($c, $i) {
            return [
                'No'          => $i + 1,
                'Title'       => $c->title,
                'Description' => $c->description,
                'Branch'      => $c->branch->name ?? '—',
                'Priority'    => ucfirst($c->priority),
                'Status'      => ucfirst(str_replace('_', ' ', $c->status)),
                'Registered'  => $c->created_at->format('d M Y'),
                'Admin Note'  => $c->admin_note ?? '—',
            ];
        });
    }

    public function headings(): array
    {
        return ['#', 'Title', 'Description', 'Branch', 'Priority', 'Status', 'Date', 'Note'];
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
            'A' => 5,
            'B' => 30,
            'C' => 40,
            'D' => 20,
            'E' => 12,
            'F' => 15,
            'G' => 15,
            'H' => 30,
        ];
    }
}