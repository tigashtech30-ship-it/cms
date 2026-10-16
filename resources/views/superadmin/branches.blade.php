<x-app-layout>
    <x-slot name="header">All Branches — Monitor</x-slot>

    <div class="table-card">
        <div class="card-header">
            <h5 class="mb-0 fw-bold text-dark">All Branches</h5>
            <small class="text-muted">Branch statistics overview</small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Branch</th>
                        <th>Code</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Users</th>
                        <th>Complaints</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
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
                            <span class="branch-code-badge">
                                {{ $branch->branch_code }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $branch->location ?? '—' }}</td>
                        <td class="text-muted">{{ $branch->phone ?? '—' }}</td>
                        <td>
                            <span class="badge bg-primary rounded-pill">
                                {{ $branch->users_count }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark rounded-pill">
                                {{ $branch->complaints_count }}
                            </span>
                        </td>
                        <td>
                            @if($branch->is_active)
                                <span class="badge-active">● Active</span>
                            @else
                                <span class="badge-inactive">● Inactive</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            No branches found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>