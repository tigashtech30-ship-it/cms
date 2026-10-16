<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Complaint Slip — {{ $complaint->tracking_number }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; font-size:13px;
               color:#333; background:#fff; }
        .slip { max-width:700px; margin:20px auto; padding:20px;
                border:2px solid #1e3a5f; border-radius:8px; }

        /* Header */
        .header { text-align:center; padding-bottom:15px;
                  border-bottom:2px solid #1e3a5f; margin-bottom:15px; }
        .header h2 { color:#1e3a5f; font-size:20px; margin-bottom:3px; }
        .header p  { color:#666; font-size:12px; }

        /* Tracking Number */
        .tracking-box { background:#1e3a5f; color:white;
                        text-align:center; padding:12px;
                        border-radius:6px; margin-bottom:15px; }
        .tracking-box .label { font-size:11px; opacity:0.8; }
        .tracking-box .number { font-size:26px; font-weight:700;
                                letter-spacing:3px; }

        /* Info Grid */
        .info-grid { display:grid; grid-template-columns:1fr 1fr;
                     gap:10px; margin-bottom:15px; }
        .info-item { background:#f8f9fc; padding:10px;
                     border-radius:6px; }
        .info-item .label { font-size:11px; color:#666;
                            margin-bottom:3px; }
        .info-item .value { font-weight:700; color:#1e3a5f; }

        /* Priority Badge */
        .priority-urgent { color:#dc2626; }
        .priority-high    { color:#d97706; }
        .priority-medium  { color:#2563eb; }
        .priority-low     { color:#6b7280; }

        /* Description */
        .section { margin-bottom:12px; }
        .section-title { font-weight:700; color:#1e3a5f;
                         font-size:12px; text-transform:uppercase;
                         letter-spacing:0.5px; margin-bottom:5px;
                         padding-bottom:3px;
                         border-bottom:1px solid #e5e7eb; }
        .section-content { color:#444; line-height:1.6; font-size:13px; }

        /* Status */
        .status-box { display:inline-block; padding:4px 12px;
                      border-radius:20px; font-weight:700;
                      font-size:12px; }
        .status-assigned    { background:#cfe2ff; color:#084298; }
        .status-in_progress { background:#d1ecf1; color:#0c5460; }
        .status-resolved    { background:#d1fae5; color:#065f46; }
        .status-pending     { background:#fff3cd; color:#856404; }
        .status-closed      { background:#e2e3e5; color:#383d41; }

        /* Footer */
        .footer { margin-top:15px; padding-top:10px;
                  border-top:1px dashed #ccc;
                  display:flex; justify-content:space-between;
                  align-items:center; }
        .footer .sign-box { text-align:center; }
        .footer .sign-line { border-top:1px solid #333;
                             width:150px; margin:30px auto 3px; }
        .footer small { color:#999; font-size:11px; }

        @media print {
            .no-print { display:none; }
            body { margin:0; }
            .slip { border:2px solid #1e3a5f; margin:0; }
        }
    </style>
</head>
<body>

    {{-- Print Button --}}
    <div class="no-print" style="text-align:center;padding:15px;">
        <button onclick="window.print()"
                style="background:#1e3a5f;color:white;border:none;
                       padding:10px 30px;border-radius:8px;
                       font-size:14px;cursor:pointer;margin-right:10px;">
            🖨️ Print Slip
        </button>
        <a href="{{ route('admin.complaints.show', $complaint) }}"
           style="background:#6c757d;color:white;border:none;
                  padding:10px 30px;border-radius:8px;
                  font-size:14px;cursor:pointer;text-decoration:none;">
            ← Back
        </a>
    </div>

    <div class="slip">

        {{-- Header --}}
        <div class="header">
            <h2>Complaint Management System</h2>
            <p>Official Complaint Receipt / Acknowledgement Slip</p>
        </div>

        {{-- Tracking Number --}}
        <div class="tracking-box">
            <div class="label">TRACKING NUMBER / CUSTOMER ID</div>
            <div class="number">{{ $complaint->tracking_number }}</div>
        </div>

        {{-- Info Grid --}}
        <div class="info-item">
            <div class="label">Complaint Type</div>
            <div class="value">
               {{ ucwords(str_replace('_',' ',$complaint->complaint_type)) }}
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Customer Name</div>
                <div class="value">{{ $complaint->customer_name ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Date Registered</div>
                <div class="value">
                    {{ $complaint->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
            <div class="info-item">
                <div class="label">Branch Assigned</div>
                <div class="value">{{ $complaint->branch->name }}</div>
            </div>
            <div class="info-item">
                <div class="label">Department</div>
                <div class="value">
                    {{ $complaint->category->name ?? '—' }}
                </div>
            </div>
            <div class="info-item">
                <div class="label">Priority</div>
                <div class="value priority-{{ $complaint->priority }}">
                    {{ strtoupper($complaint->priority) }}
                </div>
            </div>
            <div class="info-item">
                <div class="label">Status</div>
                <div class="value">
                    <span class="status-box status-{{ $complaint->status }}">
                        {{ ucfirst(str_replace('_',' ',$complaint->status)) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Complaint Title --}}
        <div class="section">
            <div class="section-title">Complaint</div>
            <div class="section-content">
                <strong>{{ $complaint->title }}</strong>
            </div>
        </div>

        {{-- Description --}}
        <div class="section">
            <div class="section-title">Description</div>
            <div class="section-content">{{ $complaint->description }}</div>
        </div>

        {{-- Admin Note --}}
        @if($complaint->admin_note)
        <div class="section">
            <div class="section-title">Note</div>
            <div class="section-content">{{ $complaint->admin_note }}</div>
        </div>
        @endif

        {{-- Footer / Signature --}}
        <div class="footer">
            <div class="sign-box">
                <div class="sign-line"></div>
                <div>Authorized Signature</div>
                <small>Admin / Officer</small>
            </div>
            <div style="text-align:right;">
                <small style="color:#999;">
                    Generated: {{ now()->format('d M Y, h:i A') }}<br>
                    Complaint Management System<br>
                    Keep this slip for reference
                </small>
            </div>
        </div>

    </div>

</body>
</html>