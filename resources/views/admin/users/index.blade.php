<x-app-layout>
    <x-slot name="header">User Management</x-slot>

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card stat-card-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Users</div>
                        <div class="number">{{ $users->count() }}</div>
                    </div>
                    <i class="bi bi-people icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Assigned Users</div>
                        <div class="number">{{ $users->whereNotNull('branch_id')->count() }}</div>
                    </div>
                    <i class="bi bi-person-check icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Unassigned Users</div>
                        <div class="number">{{ $users->whereNull('branch_id')->count() }}</div>
                    </div>
                    <i class="bi bi-person-dash icon"></i>
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
                <h5 class="mb-0 fw-bold text-dark">All Branch Users</h5>
                <small class="text-muted">Manage users and their branch assignments</small>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-person-plus"></i> Add User
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="branch-avatar" style="background:#e0f2fe;color:#0369a1;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="fw-semibold">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            @if($user->branch)
                                <span class="branch-code-badge">
                                    <i class="bi bi-building me-1"></i>
                                    {{ $user->branch->name }}
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Not Assigned
                                </span>
                            @endif
                        </td>
                        <td class="text-muted">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete {{ $user->name }}?')">
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
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-people text-muted" style="font-size:40px;"></i>
                            <p class="text-muted mt-2 mb-0">No users found</p>
                            <a href="{{ route('admin.users.create') }}"
                               class="btn btn-primary btn-sm mt-2">
                                + Add First User
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>