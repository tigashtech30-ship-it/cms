<x-app-layout>
    <x-slot name="header">Complaint Management</x-slot>

    {{-- Overall Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-card-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total</div>
                        <div class="number">{{ $total }}</div>
                    </div>
                    <i class="bi bi-clipboard-data icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card"
                 style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Pending</div>
                        <div class="number">{{ $pending }}</div>
                    </div>
                    <i class="bi bi-hourglass-split icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card"
                 style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">In Progress</div>
                        <div class="number">{{ $inProgress }}</div>
                    </div>
                    <i class="bi bi-arrow-repeat icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Resolved</div>
                        <div class="number">{{ $resolved }}</div>
                    </div>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Branch-wise Stats --}}
    <div class="table-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-bold text-dark">
                <i class="bi bi-building me-2 text-primary"></i>
                Branch-wise Overview
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Total</th>
                        <th>Pending</th>
                        <th>In Progress</th>
                        <th>Resolved</th>
                        <th>Progress</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branchStats as $bs)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="branch-avatar">
                                    {{ strtoupper(substr($bs->name, 0, 2)) }}
                                </span>
                                <span class="fw-semibold">{{ $bs->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary rounded-pill">
                                {{ $bs->complaints_count }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark rounded-pill">
                                {{ $bs->branch_pending }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark rounded-pill">
                                {{ $bs->branch_inprogress }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success rounded-pill">
                                {{ $bs->branch_resolved }}
                            </span>
                        </td>
                        <td style="min-width:120px;">
                            @php
                                $rate = $bs->complaints_count > 0
                                    ? round(($bs->branch_resolved / $bs->complaints_count) * 100)
                                    : 0;
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px;">
                                    <div class="progress-bar bg-success"
                                         style="width:{{ $rate }}%"></div>
                                </div>
                                <small class="text-muted">{{ $rate }}%</small>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.complaints.index', ['branch_id' => $bs->id]) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
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
            <form method="GET" action="{{ route('admin.complaints.index') }}">
                <div class="row g-2 mb-2">

                    {{-- Search Box --}}
                    <div class="col-md-3">
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

                    {{-- Branch --}}
                    <div class="col-md-2">
                        <select name="branch_id" class="form-select"
                                onchange="this.form.submit()">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-2">
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Complaint Type ✅ இங்கே சரியான இடம் --}}
                    <div class="col-md-2">
                        <select name="complaint_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="assessment_tax_payer"
                                {{ request('complaint_type')=='assessment_tax_payer' ?'selected':'' }}>
                                🏦 Assessment Tax Payer
                            </option>
                            <option value="general_complaint"
                                {{ request('complaint_type')=='general_complaint' ?'selected':'' }}>
                                📝 General Complaint
                            </option>
                        </select>
                    </div>

                    {{-- Status --}}
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
                </div>

                <div class="row g-2">
                    {{-- Priority --}}
                    <div class="col-md-2">
                        <select name="priority" class="form-select">
                            <option value="">All Priority</option>
                            <option value="low"    {{ request('priority')=='low'    ?'selected':'' }}>🟢 Low</option>
                            <option value="medium" {{ request('priority')=='medium' ?'selected':'' }}>🔵 Medium</option>
                            <option value="high"   {{ request('priority')=='high'   ?'selected':'' }}>🟠 High</option>
                            <option value="urgent" {{ request('priority')=='urgent' ?'selected':'' }}>🔴 Urgent</option>
                        </select>
                    </div>

                    {{-- Date Range --}}
                    <div class="col-md-2">
                        <input type="date" name="from_date"
                               value="{{ request('from_date') }}"
                               class="form-control" title="From Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to_date"
                               value="{{ request('to_date') }}"
                               class="form-control" title="To Date">
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('admin.complaints.index') }}"
                           class="btn btn-outline-secondary flex-fill">
                            <i class="bi bi-x"></i> Clear
                        </a>
                    </div>

                    {{-- Active Filters --}}
                    @if(request()->anyFilled(['search','branch_id','status','priority','category_id','complaint_type','from_date','to_date']))
                    <div class="col-md-4 d-flex align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-funnel-fill text-primary me-1"></i>
                            Showing filtered results —
                            <strong>{{ $complaints->total() }}</strong> found
                        </small>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Complaints Table --}}
    <div class="table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">
                    Complaints List
                    @if(request('branch_id'))
                        — {{ $branches->find(request('branch_id'))->name ?? '' }}
                    @endif
                </h5>
                <small class="text-muted">
                    Showing {{ $complaints->firstItem() ?? 0 }}–{{ $complaints->lastItem() ?? 0 }}
                    of {{ $complaints->total() }}
                </small>
            </div>
            <a href="{{ route('admin.complaints.create') }}"
               class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> New Complaint
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tracking No</th>
                        <th>Customer</th>
                        <th>Complaint</th>
                        <th>Type</th>
                        <th>Branch</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                    <tr>
                        <td>
                            <span class="branch-code-badge fw-bold">
                                #{{ $complaint->tracking_number ?? $complaint->id }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold small">
                                {{ $complaint->customer_name ?? '—' }}
                            </div>
                            <small class="text-muted">
                                {{ $complaint->customer_id ?? '' }}
                            </small>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $complaint->title }}</div>
                            <small class="text-muted">
                                {{ Str::limit($complaint->description, 40) }}
                            </small>
                        </td>

                        {{-- Complaint Type ✅ சரியான இடம் --}}
                        <td>
                            @if($complaint->complaint_type == 'assessment_tax_payer')
                                <span class="badge bg-primary rounded-pill">
                                    🏦 Tax Payer
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill">
                                    📝 General
                                </span>
                            @endif
                        </td>

                        <td>
                            <span class="branch-code-badge">
                                {{ $complaint->branch->name }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $complaint->category->name ?? '—' }}
                        </td>
                        <td>
                            @php
                                $priorityClass = [
                                    'low'    => 'bg-secondary',
                                    'medium' => 'bg-info text-dark',
                                    'high'   => 'bg-warning text-dark',
                                    'Immediate' => 'bg-danger',
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
                            <span style="background:{{ $statusConfig['bg'] }};color:{{ $statusConfig['color'] }};padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $complaint->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.complaints.show', $complaint) }}"
                                   class="btn btn-sm btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.complaints.print', $complaint) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-success" title="Print">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <a href="{{ route('admin.complaints.edit', $complaint) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.complaints.destroy', $complaint) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="bi bi-clipboard text-muted" style="font-size:40px;"></i>
                            <p class="text-muted mt-2 mb-1">No complaints found</p>
                            @if(request()->anyFilled(['search','branch_id','status','priority','complaint_type']))
                                <a href="{{ route('admin.complaints.index') }}"
                                   class="btn btn-outline-secondary btn-sm">
                                    Clear Filters
                                </a>
                            @endif
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
</x-app-layout>