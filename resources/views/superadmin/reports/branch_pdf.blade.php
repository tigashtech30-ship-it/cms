<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Branch Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { color: #1e3a5f; margin: 0; font-size: 18px; }
        .header p { color: #666; margin: 4px 0 0; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #1e3a5f; color: white; padding: 8px 6px;
                   text-align: left; font-size: 10px; }
        tbody tr:nth-child(even) { background: #f8f9fa; }
        tbody td { padding: 7px 6px; border-bottom: 1px solid #e9ecef; }
        .active   { background: #d1fae5; color: #065f46; padding: 2px 8px;
                    border-radius: 10px; font-size: 10px; font-weight: bold; }
        .inactive { background: #fee2e2; color: #991b1b; padding: 2px 8px;
                    border-radius: 10px; font-size: 10px; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right;
                  color: #999; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Complaint Management System</h2>
        <p>Branch-wise Report — Generated on {{ now()->format('d M Y, h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Branch Name</th>
                <th>Code</th>
                <th>Location</th>
                <th>Users</th>
                <th>Total</th>
                <th>Pending</th>
                <th>In Progress</th>
                <th>Resolved</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($branches as $branch)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $branch->name }}</strong></td>
                <td>{{ $branch->branch_code }}</td>
                <td>{{ $branch->location ?? '—' }}</td>
                <td style="text-align:center;">{{ $branch->users_count }}</td>
                <td style="text-align:center;">{{ $branch->complaints_count }}</td>
                <td style="text-align:center;color:#856404;">{{ $branch->pending_count }}</td>
                <td style="text-align:center;color:#0c5460;">{{ $branch->inprogress_count }}</td>
                <td style="text-align:center;color:#065f46;">{{ $branch->resolved_count }}</td>
                <td>
                    <span class="{{ $branch->is_active ? 'active' : 'inactive' }}">
                        {{ $branch->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Complaint Management System — Confidential Report
    </div>
</body>
</html>