<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6fb;
               margin:0; padding:20px; color:#333; }
        .container { max-width:600px; margin:0 auto; }
        .header { background:linear-gradient(135deg,#1e3a5f,#4e9af1);
                  padding:30px; border-radius:12px 12px 0 0; text-align:center; }
        .header h1 { color:white; margin:0; font-size:22px; }
        .header p  { color:rgba(255,255,255,0.8); margin:8px 0 0; font-size:14px; }
        .body { background:white; padding:30px;
                border-radius:0 0 12px 12px; }
        .info-box { background:#f8f9fc; border-radius:8px;
                    padding:15px 20px; margin:15px 0; }
        .info-row { display:flex; justify-content:space-between;
                    padding:8px 0; border-bottom:1px solid #eee; }
        .info-row:last-child { border-bottom:none; }
        .label { color:#666; font-size:13px; }
        .value { font-weight:600; font-size:13px; color:#1e3a5f; }
        .priority-urgent { color:#dc2626; font-weight:700; }
        .priority-high    { color:#d97706; font-weight:700; }
        .priority-medium  { color:#2563eb; font-weight:700; }
        .priority-low     { color:#6b7280; font-weight:700; }
        .btn { display:inline-block; background:#1e3a5f; color:white;
               padding:12px 30px; border-radius:8px; text-decoration:none;
               font-weight:600; margin-top:20px; }
        .footer { text-align:center; color:#999; font-size:12px;
                  margin-top:20px; }
        .description-box { background:#fffbeb; border:1px solid #fde68a;
                           border-radius:8px; padding:15px; margin:15px 0;
                           font-size:14px; line-height:1.6; }
    </style>
</head>
<body>
    <div class="container">

        {{-- Header --}}
        <div class="header">
            <h1>📋 New Complaint Assigned</h1>
            <p>Complaint Management System</p>
        </div>

        {{-- Body --}}
        <div class="body">
            <p style="font-size:15px;">
                Dear <strong>{{ $complaint->branch->name }}</strong> Team,
            </p>
            <p style="color:#555;font-size:14px;line-height:1.6;">
                A new complaint has been assigned to your branch.
                Please review and take appropriate action as soon as possible.
            </p>

            {{-- Complaint Details --}}
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Complaint Title</span>
                    <span class="value">{{ $complaint->title }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Branch</span>
                    <span class="value">
                        {{ $complaint->branch->name }}
                        ({{ $complaint->branch->branch_code }})
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Priority</span>
                    <span class="value priority-{{ $complaint->priority }}">
                        {{ strtoupper($complaint->priority) }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Status</span>
                    <span class="value">Assigned</span>
                </div>
                <div class="info-row">
                    <span class="label">Date</span>
                    <span class="value">
                        {{ $complaint->created_at->format('d M Y, h:i A') }}
                    </span>
                </div>
            </div>

            {{-- Description --}}
            <p style="font-weight:600;color:#444;margin-bottom:5px;">
                Description:
            </p>
            <div class="description-box">
                {{ $complaint->description }}
            </div>

            {{-- Admin Note --}}
            @if($complaint->admin_note)
            <p style="font-weight:600;color:#444;margin-bottom:5px;">
                Admin Note:
            </p>
            <div class="description-box" style="background:#f0f9ff;border-color:#bae6fd;">
                {{ $complaint->admin_note }}
            </div>
            @endif

            <p style="color:#555;font-size:14px;margin-top:20px;">
                Please login to the system to view and update this complaint.
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>This is an automated email from Complaint Management System.</p>
            <p>Please do not reply to this email.</p>
        </div>

    </div>
</body>
</html>