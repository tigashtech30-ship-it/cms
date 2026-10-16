<x-app-layout>
    <x-slot name="header">Reports & Downloads</x-slot>

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-card-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total</div>
                        <div class="number">{{ $totalComplaints }}</div>
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
                        <div class="number">{{ $totalPending }}</div>
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
                        <div class="number">{{ $totalInProgress }}</div>
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
                        <div class="number">{{ $totalResolved }}</div>
                    </div>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Complaints Report --}}
    <div class="table-card mb-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-clipboard-data me-2 text-primary"></i>
                Complaints Report
            </h5>
            <small class="text-muted">Filter and download complaint data</small>
        </div>

        <div class="p-4">
            {{-- Filter Form --}}
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Branch</label>
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending"     {{ request('status')=='pending'     ?'selected':'' }}>Pending</option>
                        <option value="assigned"    {{ request('status')=='assigned'    ?'selected':'' }}>Assigned</option>
                        <option value="in_progress" {{ request('status')=='in_progress' ?'selected':'' }}>In Progress</option>
                        <option value="resolved"    {{ request('status')=='resolved'    ?'selected':'' }}>Resolved</option>
                        <option value="closed"      {{ request('status')=='closed'      ?'selected':'' }}>Closed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="">All Priority</option>
                        <option value="low"    {{ request('priority')=='low'    ?'selected':'' }}>Low</option>
                        <option value="medium" {{ request('priority')=='medium' ?'selected':'' }}>Medium</option>
                        <option value="high"   {{ request('priority')=='high'   ?'selected':'' }}>High</option>
                        <option value="urgent" {{ request('priority')=='urgent' ?'selected':'' }}>Urgent</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">From Date</label>
                    <input type="date" name="from_date"
                           value="{{ request('from_date') }}"
                           class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">To Date</label>
                    <input type="date" name="to_date"
                           value="{{ request('to_date') }}"
                           class="form-control">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>

            {{-- Download Buttons --}}
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('superadmin.reports.complaints.excel', request()->all()) }}"
                   class="btn btn-success d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-excel"></i>
                    Download Excel
                </a>
                <a href="{{ route('superadmin.reports.complaints.pdf', request()->all()) }}"
                   class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Download PDF
                </a>
            </div>
        </div>
    </div>

    {{-- Branch Report --}}
    <div class="table-card mb-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-building me-2 text-success"></i>
                Branch-wise Report
            </h5>
            <small class="text-muted">Download complaint statistics per branch</small>
        </div>

        <div class="p-4">
            {{-- Branch Stats Table --}}
            <div class="table-responsive mb-4">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Branch</th>
                            <th>Total</th>
                            <th>Pending</th>
                            <th>Resolved</th>
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branchStats as $branch)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="branch-avatar">
                                        {{ strtoupper(substr($branch->name, 0, 2)) }}
                                    </span>
                                    <span class="fw-semibold">{{ $branch->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $branch->complaints_count }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark rounded-pill">
                                    {{ $branch->pending_count }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success rounded-pill">
                                    {{ $branch->resolved_count }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $rate = $branch->complaints_count > 0
                                        ? round(($branch->resolved_count / $branch->complaints_count) * 100)
                                        : 0;
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height:8px;">
                                        <div class="progress-bar bg-success"
                                             style="width:{{ $rate }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $rate }}%</small>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Download Buttons --}}
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('superadmin.reports.branches.excel') }}"
                   class="btn btn-success d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-excel"></i>
                    Download Excel
                </a>
                <a href="{{ route('superadmin.reports.branches.pdf') }}"
                   class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Download PDF
                </a>
            </div>
        </div>
    </div>

</x-app-layout>