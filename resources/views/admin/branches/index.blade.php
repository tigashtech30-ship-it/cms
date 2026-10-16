<x-app-layout>
    <x-slot name="header">Branch Management</x-slot>

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card stat-card-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Branches</div>
                        <div class="number">{{ $branches->count() }}</div>
                    </div>
                    <i class="bi bi-building icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Active Branches</div>
                        <div class="number">{{ $branches->where('is_active', true)->count() }}</div>
                    </div>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Users</div>
                        <div class="number">{{ $branches->sum('users_count') }}</div>
                    </div>
                    <i class="bi bi-people icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">All Branches</h5>
                <small class="text-muted">Manage your 27 office branches</small>
            </div>
            <a href="{{ route('admin.branches.create') }}"
               class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add Branch
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Branch Name</th>
                        <th>Code</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Users</th>
                        <th>Complaints</th>
                        <th>Status</th>
                        <th>Actions</th>
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
                        <td><span class="branch-code-badge">{{ $branch->branch_code }}</span></td>
                        <td class="text-muted">{{ $branch->location ?? '—' }}</td>
                        <td class="text-muted">{{ $branch->phone ?? '—' }}</td>
                        <td>
                            <span class="badge bg-primary rounded-pill">{{ $branch->users_count }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $branch->complaints_count }}</span>
                        </td>
                        <td>
                            @if($branch->is_active)
                                <span class="badge-active">● Active</span>
                            @else
                                <span class="badge-inactive">● Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.branches.edit', $branch) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.branches.destroy', $branch) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete {{ $branch->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-building text-muted" style="font-size:40px;"></i>
                            <p class="text-muted mt-2 mb-0">No branches found</p>
                            <a href="{{ route('admin.branches.create') }}" class="btn btn-primary btn-sm mt-2">
                                + Add First Branch
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>