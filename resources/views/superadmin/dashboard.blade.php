<x-app-layout>
    <x-slot name="header">Super Admin Dashboard</x-slot>

    {{-- Welcome Banner --}}
    <div class="p-4 rounded-3 mb-4 text-white"
         style="background:linear-gradient(135deg,#1a1a2e,#16213e,#0f3460);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">
                    👑 Super Admin Panel
                </h4>
                <p class="mb-0 opacity-75">
                    Full system monitoring access —
                    {{ now()->format('d M Y, h:i A') }}
                </p>
            </div>
            <i class="bi bi-shield-check"
               style="font-size:52px;opacity:0.3;"></i>
        </div>
    </div>

    {{-- Main Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-2 col-sm-4">
            <div class="stat-card stat-card-1 text-center">
                <i class="bi bi-building icon mb-2"></i>
                <div class="number">{{ $totalBranches }}</div>
                <div class="label">Branches</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card stat-card-2 text-center">
                <i class="bi bi-people icon mb-2"></i>
                <div class="number">{{ $totalUsers }}</div>
                <div class="label">Users</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card stat-card-3 text-center">
                <i class="bi bi-clipboard-data icon mb-2"></i>
                <div class="number">{{ $totalComplaints }}</div>
                <div class="label">Total</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card text-center"
                 style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                <i class="bi bi-hourglass-split icon mb-2"></i>
                <div class="number">{{ $totalPending }}</div>
                <div class="label">Pending</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card text-center"
                 style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
                <i class="bi bi-arrow-repeat icon mb-2"></i>
                <div class="number">{{ $totalInProgress }}</div>
                <div class="label">In Progress</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card text-center"
                 style="background:linear-gradient(135deg,#43e97b,#38f9d7);">
                <i class="bi bi-check-circle icon mb-2"></i>
                <div class="number">{{ $totalResolved }}</div>
                <div class="label">Resolved</div>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('superadmin.complaints') }}"
               class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-3 p-3"
                     style="transition:0.2s;border-left:4px solid #667eea !important;"
                     onmouseover="this.style.transform='translateY(-2px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-clipboard-data text-primary"
                           style="font-size:32px;"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">All Complaints</h6>
                            <small class="text-muted">Monitor all complaints</small>
                        </div>
                        <i class="bi bi-chevron-right text-muted ms-auto"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('superadmin.branches') }}"
               class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-3 p-3"
                     style="transition:0.2s;border-left:4px solid #11998e !important;"
                     onmouseover="this.style.transform='translateY(-2px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-building text-success"
                           style="font-size:32px;"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">All Branches</h6>
                            <small class="text-muted">View branch statistics</small>
                        </div>
                        <i class="bi bi-chevron-right text-muted ms-auto"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('superadmin.users') }}"
               class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-3 p-3"
                     style="transition:0.2s;border-left:4px solid #f5576c !important;"
                     onmouseover="this.style.transform='translateY(-2px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-people text-danger"
                           style="font-size:32px;"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">All Users</h6>
                            <small class="text-muted">View all system users</small>
                        </div>
                        <i class="bi bi-chevron-right text-muted ms-auto"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Recent Complaints --}}
    <div class="table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">Recent Complaints</h5>
                <small class="text-muted">Latest 10 complaints across all branches</small>
            </div>
            <a href="{{ route('superadmin.complaints') }}"
               class="btn btn-sm btn-outline-primary">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Complaint</th>
                        <th>Branch</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentComplaints as $complaint)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-semibold">{{ $complaint->title }}</div>
                            <small class="text-muted">
                                {{ Str::limit($complaint->description, 50) }}
                            </small>
                        </td>
                        <td>
                            <span class="branch-code-badge">
                                <i class="bi bi-building me-1"></i>
                                {{ $complaint->branch->name }}
                            </span>
                        </td>
                        <td>
                            @php
                                $priorityClass = [
                                    'low'    => 'bg-secondary',
                                    'medium' => 'bg-info text-dark',
                                    'high'   => 'bg-warning text-dark',
                                    'urgent' => 'bg-danger',
                                ][$complaint->priority] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $priorityClass }} rounded-pill">
                                {{ ucfirst($complaint->priority) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending'     => ['bg'=>'#fff3cd','color'=>'#856404','label'=>'Pending'],
                                    'assigned'    => ['bg'=>'#cfe2ff','color'=>'#084298','label'=>'Assigned'],
                                    'in_progress' => ['bg'=>'#d1ecf1','color'=>'#0c5460','label'=>'In Progress'],
                                    'resolved'    => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Resolved'],
                                    'closed'      => ['bg'=>'#e2e3e5','color'=>'#383d41','label'=>'Closed'],
                                ][$complaint->status] ?? ['bg'=>'#e2e3e5','color'=>'#383d41','label'=>ucfirst($complaint->status)];
                            @endphp
                            <span style="background:{{ $statusConfig['bg'] }};color:{{ $statusConfig['color'] }};padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $complaint->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No complaints found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>