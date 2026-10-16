<x-app-layout>
    <x-slot name="header">All Users — Monitor</x-slot>

    <div class="table-card">
        <div class="card-header">
            <h5 class="mb-0 fw-bold text-dark">All System Users</h5>
            <small class="text-muted">Admins and Branch users</small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Branch</th>
                        <th>Last Login</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="branch-avatar"
                                     style="background:#e0f2fe;color:#0369a1;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="fw-semibold">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger rounded-pill">
                                    <i class="bi bi-shield me-1"></i>Admin
                                </span>
                            @else
                                <span class="badge bg-primary rounded-pill">
                                    <i class="bi bi-person me-1"></i>Branch User
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->branch)
                                <span class="branch-code-badge">
                                    <i class="bi bi-building me-1"></i>
                                    {{ $user->branch->name }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            @if($user->last_login_at)
                                <span class="text-success">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $user->last_login_at->diffForHumans() }}
                                </span>
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-people text-muted"
                               style="font-size:40px;"></i>
                            <p class="text-muted mt-2 mb-0">No users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>