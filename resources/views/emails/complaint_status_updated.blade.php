<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6fb;
               margin:0; padding:20px; color:#333; }
        .container { max-width:600px; margin:0 auto; }
        .header { padding:30px; border-radius:12px 12px 0 0; text-align:center; }
        .header h1 { color:white; margin:0; font-size:22px; }
        .header p  { color:rgba(255,255,255,0.8); margin:8px 0 0; font-size:14px; }
        .header-inprogress { background:linear-gradient(135deg,#0891b2,#06b6d4); }
        .header-resolved   { background:linear-gradient(135deg,#059669,#34d399); }
        .body { background:white; padding:30px; border-radius:0 0 12px 12px; }
        .info-box { background:#f8f9fc; border-radius:8px; padding:15px 20px; margin:15px 0; }
        .info-row { display:flex; justify-content:space-between;
                    padding:8px 0; border-bottom:1px solid #eee; }
        .info-row:last-child { border-bottom:none; }
        .label { color:#666; font-size:13px; }
        .value { font-weight:600; font-size:13px; color:#1e3a5f; }
        .status-badge { padding:4px 12px; border-radius:20px; font-weight:700; font-size:13px; }
        .status-in_progress { background:#d1ecf1; color:#0c5460; }
        .status-resolved    { background:#d1fae5; color:#065f46; }
        .footer { text-align:center; color:#999; font-size:12px; margin-top:20px; }
    </style>
</head>
<body>
    <div class="container">

        @php
            $headerClass = $complaint->status === 'resolved'
                ? 'header-resolved' : 'header-inprogress';
            $icon = $complaint->status === 'resolved' ? '✅' : '🔄';
        @endphp

        <div class="header {{ $headerClass }}">
            <h1>{{ $icon }} Complaint Status Updated</h1>
            <p>Complaint Management System</p>
        </div>

        <div class="body">
            <p style="font-size:15px;">Dear <strong>Admin</strong>,</p>
            <p style="color:#555;font-size:14px;line-height:1.6;">
                A complaint status has been updated by the branch team.
            </p>

            <div class="info-box">
                <div class="info-row">
                    <span class="label">Tracking No</span>
                    <span class="value">#{{ $complaint->tracking_number ?? $complaint->id }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Complaint</span>
                    <span class="value">{{ $complaint->title }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Branch</span>
                    <span class="value">{{ $complaint->branch->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">New Status</span>
                    <span class="value">
                        <span class="status-badge status-{{ $complaint->status }}">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Updated On</span>
                    <span class="value">{{ now()->format('d M Y, h:i A') }}</span>
                </div>
            </div>

            @if($complaint->admin_note)
            <p style="font-weight:600;color:#444;margin-bottom:5px;">Branch Note:</p>
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;
                        padding:15px;font-size:14px;white-space:pre-line;">
                {{ $complaint->admin_note }}
            </div>
            @endif
        </div>

        <div class="footer">
            <p>This is an automated email from Complaint Management System.</p>
        </div>
    </div>
</body>
</html>