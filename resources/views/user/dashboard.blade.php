<x-app-layout>
    <x-slot name="header">My Dashboard</x-slot>

    {{-- Welcome Banner --}}
    <div class="p-4 rounded-3 mb-4 text-white"
         style="background:linear-gradient(135deg,#1e3a5f,#4e9af1);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Welcome, {{ Auth::user()->name }}! 👋</h4>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-building me-1"></i>
                    {{ $branch->name ?? 'No Branch Assigned' }}
                    @if($branch)
                        &nbsp;|&nbsp;
                        <span class="badge bg-white text-primary">
                            {{ $branch->branch_code }}
                        </span>
                    @endif
                </p>
            </div>
            <i class="bi bi-person-circle" style="font-size:48px;opacity:0.4;"></i>
        </div>
    </div>

    @if(!$branch)
        <div class="alert alert-warning d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>உங்களுக்கு இன்னும் Branch assign ஆகவில்லை. Admin-ஐ தொடர்பு கொள்ளுங்க!</div>
        </div>
    @else

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-card-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div><div class="label">Total</div><div class="number">{{ $total }}</div></div>
                    <i class="bi bi-clipboard-data icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                <div class="d-flex justify-content-between align-items-center">
                    <div><div class="label">Pending</div><div class="number">{{ $pending }}</div></div>
                    <i class="bi bi-hourglass-split icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
                <div class="d-flex justify-content-between align-items-center">
                    <div><div class="label">In Progress</div><div class="number">{{ $inProgress }}</div></div>
                    <i class="bi bi-arrow-repeat icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div><div class="label">Resolved</div><div class="number">{{ $resolved }}</div></div>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
            <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Search & Filter --}}
    <div class="table-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-bold text-dark">
                <i class="bi bi-search me-2"></i>Search & Filter
            </h6>
        </div>
        <div class="p-3">
            <form method="GET" action="{{ route('user.dashboard') }}">
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search"
                                   value="{{ request('search') }}"
                                   class="form-control"
                                   placeholder="Complaint No / Customer ID / Name...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="complaint_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="assessment_tax_payer"
                                {{ request('complaint_type')=='assessment_tax_payer' ?'selected':'' }}>
                                🏦 Tax Payer
                            </option>
                            <option value="general_complaint"
                                {{ request('complaint_type')=='general_complaint' ?'selected':'' }}>
                                📝 General
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending"     {{ request('status')=='pending'     ?'selected':'' }}>⏳ Pending</option>
                            <option value="assigned"    {{ request('status')=='assigned'    ?'selected':'' }}>📌 Assigned</option>
                            <option value="in_progress" {{ request('status')=='in_progress' ?'selected':'' }}>🔄 In Progress</option>
                            <option value="resolved"    {{ request('status')=='resolved'    ?'selected':'' }}>✅ Resolved</option>
                            <option value="closed"      {{ request('status')=='closed'      ?'selected':'' }}>🔒 Closed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="priority" class="form-select">
                            <option value="">All Priority</option>
                            <option value="low"    {{ request('priority')=='low'    ?'selected':'' }}>🟢 Low</option>
                            <option value="medium" {{ request('priority')=='medium' ?'selected':'' }}>🔵 Medium</option>
                            <option value="high"   {{ request('priority')=='high'   ?'selected':'' }}>🟠 High</option>
                            <option value="urgent" {{ request('priority')=='urgent' ?'selected':'' }}>🔴 Urgent</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('user.dashboard') }}"
                           class="btn btn-outline-secondary flex-fill">
                            <i class="bi bi-x"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Complaints Table --}}
    <div class="table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">My Branch Complaints</h5>
                <small class="text-muted">
                    Only complaints assigned to <strong>{{ $branch->name }}</strong>
                </small>
            </div>
            <span class="badge bg-primary rounded-pill px-3 py-2">
                {{ $total }} Total
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tracking No</th>
                        <th>Complaint</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                    <tr>
                        {{-- # --}}
                        <td class="text-muted">{{ $loop->iteration }}</td>

                        {{-- Tracking No --}}
                        <td>
                            <span class="branch-code-badge fw-bold">
                                #{{ $complaint->tracking_number ?? $complaint->id }}
                            </span>
                        </td>

                        {{-- Complaint --}}
                        <td>
                            <div class="fw-semibold">{{ $complaint->title }}</div>
                            <small class="text-muted">
                                {{ $complaint->customer_name ?? '' }}
                            </small>
                        </td>

                        {{-- Type ✅ சரியான இடம் --}}
                        <td>
                            @if($complaint->complaint_type == 'assessment_tax_payer')
                                <span class="badge bg-primary rounded-pill">🏦 Tax Payer</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">📝 General</span>
                            @endif
                        </td>

                        {{-- Priority --}}
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

                        {{-- Status --}}
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

                        {{-- Date --}}
                        <td class="text-muted small">
                            {{ $complaint->created_at->format('d M Y') }}
                        </td>

                        {{-- Action --}}
                        <td>
                            <a href="{{ route('user.complaint.show', $complaint) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-clipboard text-muted" style="font-size:40px;"></i>
                            <p class="text-muted mt-2 mb-0">No complaints found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($complaints->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Page {{ $complaints->currentPage() }} of {{ $complaints->lastPage() }}
            </small>
            {{ $complaints->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    @endif
</x-app-layout>